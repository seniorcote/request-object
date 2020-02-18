<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationErrorsJsonResponse.
 */
final class DefaultValidationErrorsResponse implements ValidationErrorsResponse
{
    /**
     * {@inheritDoc}
     */
    public function build(ConstraintViolationListInterface $violations): Response
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}