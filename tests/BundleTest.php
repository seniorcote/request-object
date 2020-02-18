<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Seniorcote\RequestObject\Examples\App\AppKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BundleTest.
 */
final class BundleTest extends TestCase
{
    /**
     * @var AppKernel
     */
    private $kernel;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();

        $this->kernel = $kernel;
    }

    /**
     * @throws Exception
     */
    public function test(): void
    {
        $request = Request::create('/test', 'POST', [], [], [], [], json_encode([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'secret',
        ]));

        $response = $this->kernel->handle($request);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}