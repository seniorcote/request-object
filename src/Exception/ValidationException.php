<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Exception;

use Seniorcote\RequestObject\RequestObject;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationException.
 */
class ValidationException extends \Exception
{
    /**
     * @var RequestObject
     */
    private $requestObject;

    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    /**
     * ValidationException constructor.
     *
     * @param RequestObject                    $requestObject
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(RequestObject $requestObject, ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct();

        $this->requestObject = $requestObject;
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return RequestObject
     */
    public function getRequestObject(): RequestObject
    {
        return $this->requestObject;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}