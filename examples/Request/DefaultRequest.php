<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\Request;

use Seniorcote\RequestObject\RequestObjectFromJson;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DefaultRequest.
 */
final class DefaultRequest implements RequestObjectFromJson
{
    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public string $firstName;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public string $lastName;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Email()
     */
    public string $email;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public string $password;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("int")
     */
    public int $age;

    /**
     * @var array
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("array")
     */
    public array $array = [];
}