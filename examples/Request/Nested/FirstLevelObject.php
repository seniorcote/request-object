<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\Request\Nested;

use Seniorcote\RequestObject\RequestObjectFromJson;

/**
 * Class FirstLevelObject.
 */
final class FirstLevelObject implements RequestObjectFromJson
{
    /**
     * @var array|SecondLevelObject[]
     */
    public array $secondLevelObjects;
}