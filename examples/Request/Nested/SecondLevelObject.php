<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\Request\Nested;

/**
 * Class SecondLevelObject.
 */
final class SecondLevelObject
{
    /**
     * @var ThirdLevelObject
     */
    public ThirdLevelObject $thirdLevelObject;
}