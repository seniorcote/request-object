<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Seniorcote\RequestObject\TypeConverter;

/**
 * Class TypeConverterTest.
 */
final class TypeConverterTest extends TestCase
{
    /**
     * @var TypeConverter
     */
    private $converter;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->converter = new TypeConverter();
    }

    public function testConvert(): void
    {
        self::assertEquals(1, $this->converter->convert('1', TypeConverter::INTEGER));
        self::assertEquals(0.5, $this->converter->convert('0.5', TypeConverter::FLOAT));
        self::assertEquals('text', $this->converter->convert('text', TypeConverter::STRING));
    }
}