<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Builder;

use Seniorcote\RequestObject\RequestObjectFromJson;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FromJsonBuilder.
 */
final class FromJsonBody implements RequestObjectBuilder
{
    /**
     * @param Request                      $request
     * @param object|RequestObjectFromJson $requestObject
     *
     * @return RequestObjectFromJson
     *
     * @throws \ReflectionException
     */
    public function build(Request $request, object $requestObject): RequestObjectFromJson
    {
        $reflectionClass = new \ReflectionClass(get_class($requestObject));
        $properties = $reflectionClass->getProperties();
        $body = !empty($request->getContent()) ? json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR) : [];

        foreach ($body as $bodyItemKey => $bodyItemValue) {
            foreach ($properties as $propertyKey => $propertyValue) {
                if ($propertyValue->name === $bodyItemKey) {
                    if (method_exists($propertyValue, 'getType')) { // todo: Make types converter as external class.
                        switch ($propertyValue->getType()) {
                            case 'string':
                                $value = (string) $bodyItemValue; break;
                            case 'int':
                                $value = (int) $bodyItemValue; break;
                            default:
                                $value = $bodyItemValue;
                        }

                        $requestObject->{$bodyItemKey} = $value;
                    } else {
                        $requestObject->{$bodyItemKey} = $bodyItemValue;
                    }

                    unset($body[$bodyItemKey], $properties[$propertyKey]);
                }
            }
        }

        return $requestObject;
    }
}