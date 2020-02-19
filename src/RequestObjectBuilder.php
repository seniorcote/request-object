<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Seniorcote\RequestObject\Annotation\Files;
use Seniorcote\RequestObject\Annotation\QueryParam;
use Seniorcote\RequestObject\Exception\TypeConversionException;
use Seniorcote\RequestObject\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestObjectBinder.
 */
final class RequestObjectBuilder
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var TypeConverter
     */
    private $typeConverter;

    /**
     * RequestObjectBuilder constructor.
     *
     * @param ValidatorInterface $validator
     * @param TypeConverter      $typeConverter
     */
    public function __construct(ValidatorInterface $validator, TypeConverter $typeConverter)
    {
        $this->validator = $validator;
        $this->typeConverter = $typeConverter;
    }

    /**
     * @param Request       $request
     * @param RequestObject $requestObject
     *
     * @return RequestObject
     *
     * @throws \ReflectionException|AnnotationException|ValidationException|TypeConversionException
     */
    public function build(Request $request, RequestObject $requestObject): RequestObject
    {
        $reflectionClass = new \ReflectionClass(get_class($requestObject));
        $properties = $reflectionClass->getProperties();

        if (!empty($request->getContent())) {
            $body = json_decode($request->getContent(), true);
        } else {
            $body = [];
        }

        foreach ($body as $bodyItemKey => $bodyItemValue) {
            foreach ($properties as $propertyKey => $propertyValue) {
                if ($propertyValue->name === $bodyItemKey) {
                    $requestObject->{$bodyItemKey} = $bodyItemValue;

                    unset($body[$bodyItemKey], $properties[$propertyKey]);
                }
            }

        }

        $reader = new AnnotationReader();

        foreach ($request->query->all() as $queryItemKey => $queryItemValue) {
            foreach ($properties as $propertyKey => $propertyValue) {
                foreach ($reader->getPropertyAnnotations($propertyValue) as $annotation) {
                    if ($annotation instanceof QueryParam && $annotation->name === $queryItemKey) {
                        $requestObject->{$propertyValue->name} = $queryItemValue;

                        unset($request->query->all()[$queryItemKey], $properties[$propertyKey]);
                    }

                    //if ($annotation instanceof Type) {
                    //    $value = $this->typeConverter->convert($queryItemValue, $annotation->type);
                    //}
                }
            }
        }

        foreach ($properties as $property) {
            foreach ($reader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof Files) {
                    $requestObject->{$property->name} = $request->files->all();

                    break;
                }
            }
        }

        $violations = $this->validator->validate($requestObject);

        if ($violations->count() > 0) {
            throw new ValidationException($requestObject, $violations);
        }

        return $requestObject;
    }
}