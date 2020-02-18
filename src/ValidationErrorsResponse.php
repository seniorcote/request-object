<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Interface ValidationErrorsResponseBuilder.
 */
interface ValidationErrorsResponse
{
    /**
     * @param ConstraintViolationListInterface $violations
     *
     * @return Response
     */
    public function build(ConstraintViolationListInterface $violations): Response;
}