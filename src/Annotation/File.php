<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Annotation;

/**
 * Class File.
 *
 * @Annotation()
 * @Target("PROPERTY")
 */
final class File
{
    /**
     * @var string
     *
     * @Required()
     */
    public $key;
}