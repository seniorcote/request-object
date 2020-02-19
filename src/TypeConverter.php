<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject;

use Seniorcote\RequestObject\Exception\TypeConversionException;

/**
 * Class TypeConverter.
 */
final class TypeConverter
{
    public const INTEGER = 'integer';
    public const FLOAT = 'float';
    public const STRING = 'string';
    public const ARRAY = 'array';
    public const DATETIME = 'datetime';

    /**
     * @param string $value
     * @param string $type
     *
     * @return mixed
     *
     * @throws TypeConversionException
     */
    public function convert(string $value, string $type)
    {
        switch ($type) {
            case self::INTEGER:
                if (is_numeric($value)) {
                    return (int) $value;
                }

                return null;
            case self::FLOAT:
                if (is_numeric($value)) {
                    return (float) $value;
                }

                return null;
            case self::STRING:
                return trim($value);
            case self::ARRAY:
                return json_decode($value, true);
            case self::DATETIME;
                return null;
            default:
                throw new TypeConversionException('неизвестный тип');
        }
    }
}