<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Exception;

/**
 * Class ValidationException.
 */
class ValidationException extends \Exception
{
    /**
     * @var array
     */
    private array $violations;

    /**
     * ValidationException constructor.
     *
     * @param array $violations
     */
    public function __construct(array $violations)
    {
        parent::__construct();

        $this->violations = $violations;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}