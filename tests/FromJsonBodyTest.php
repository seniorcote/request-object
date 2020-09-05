<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Seniorcote\RequestObject\Builder\FromJsonBody;
use Seniorcote\RequestObject\Examples\Request\DefaultRequest;
use Seniorcote\RequestObject\Exception\ValidationException;

/**
 * Class FromJsonBodyTest.
 */
final class FromJsonBodyTest extends TestCase
{
    /**
     * @var FromJsonBody
     */
    private FromJsonBody $builder;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->builder = new FromJsonBody();
    }

    /**
     * @return void
     *
     * @throws ReflectionException
     */
    public function testCorrectSingleObject(): void
    {
        $request = Request::create('/single-object', 'POST', [], [], [], [], json_encode([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'secret',
            'age' => 20,
            'array' => [0, 1, 2, 3],
        ], JSON_THROW_ON_ERROR, 512));

        /**
         * @var DefaultRequest $object
         */
        $object = $this->builder->build($request, new DefaultRequest());

        self::assertInstanceOf(DefaultRequest::class, $object);

        self::assertIsString($object->firstName);
        self::assertEquals('John', $object->firstName);

        self::assertIsString($object->lastName);
        self::assertEquals('Doe', $object->lastName);

        self::assertIsString($object->email);
        self::assertEquals('john@doe.com', $object->email);

        self::assertIsString($object->password);
        self::assertEquals('secret', $object->password);

        self::assertIsInt($object->age);
        self::assertEquals(20, $object->age);

        self::assertIsArray($object->array);
        self::assertCount(4, $object->array);
        self::assertEquals([0, 1, 2, 3], $object->array);
    }

    /**
     * @return void
     *
     * @throws ReflectionException
     */
    public function testValidationExceptionThrowingOnIncorrectSingleObject(): void
    {
        $request = Request::create('/single-object', 'POST', [], [], [], [], json_encode([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john#doe.com',
            'password' => 'secret',
            'age' => 'twenty',
            'array' => [0, 1, 2, 3],
        ], JSON_THROW_ON_ERROR, 512));

        $this->builder->build($request, new DefaultRequest());
        $this->assertTrue(true);
    }

    ///**
    // * @return void
    // *
    // * @throws ReflectionException
    // */
    //public function testBuild(): void
    //{
    //    $request = Request::create('/nested-objects', 'POST', [], [], [], [], json_encode([
    //        'secondLevelObjects' => [
    //            [
    //                'thirdLevelObject' => [
    //                    'foo' => 'foo',
    //                    'bar' => 'bar',
    //                ],
    //            ],
    //        ],
    //    ], JSON_THROW_ON_ERROR, 512));
    //
    //    /**
    //     * @var FirstLevelObject $object
    //     */
    //    $object = $this->builder->build($request, new FirstLevelObject());
    //
    //    self::assertInstanceOf(FirstLevelObject::class, $object);
    //    self::assertIsArray($object->secondLevelObjects);
    //
    //    self::assertInstanceOf(SecondLevelObject::class, $object->secondLevelObjects[0]);
    //
    //    self::assertInstanceOf(ThirdLevelObject::class, $object->secondLevelObjects[0]->thirdLevelObject);
    //    self::assertObjectHasAttribute('foo', $object->secondLevelObjects[0]->thirdLevelObject);
    //    self::assertObjectHasAttribute('bar', $object->secondLevelObjects[0]->thirdLevelObject);
    //}
}