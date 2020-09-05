<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Builder;

use Seniorcote\RequestObject\RequestObjectFromQuery;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FromQuery.
 */
final class FromQueryParameters implements RequestObjectBuilder
{
    /**
     * @param Request                       $request
     * @param object|RequestObjectFromQuery $requestObject
     *
     * @return RequestObjectFromQuery
     *
     * @throws \ReflectionException
     */
    public function build(Request $request, object $requestObject): RequestObjectFromQuery
    {
        $reflectionClass = new \ReflectionClass(get_class($requestObject));
        $properties = $reflectionClass->getProperties();

        foreach ($request->query->all() as $queryItemKey => $queryItemValue) {
            foreach ($properties as $propertyKey => $propertyValue) {
                if ($propertyValue->name === $queryItemKey) {
                    $requestObject->{$queryItemKey} = $queryItemValue;
                }
            }
        }

        return $requestObject;
    }
}