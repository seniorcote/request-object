<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Annotation;

/**
 * Class Type.
 *
 * @Annotation()
 * @Target({"PROPERTY"})
 */
final class Type
{
    /**
     * @var string
     *
     * @Required()
     */
    public $type;
}