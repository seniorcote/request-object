<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Annotation;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class QueryParam.
 *
 * @Annotation()
 * @Target("PROPERTY")
 */
final class QueryParam
{
    /**
     * @var string
     *
     * @Required()
     */
    public $name;
}