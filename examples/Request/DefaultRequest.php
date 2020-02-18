<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\Request;

use Seniorcote\RequestObject\RequestObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DefaultRequest.
 */
final class DefaultRequest implements RequestObject
{
    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    public $firstName;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    public $lastName;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    public $password;
}