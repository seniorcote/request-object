<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\App;

use Seniorcote\RequestObject\Examples\Request\DefaultRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppController.
 */
final class AppController extends AbstractController
{
    /**
     * @param DefaultRequest $request
     *
     * @return JsonResponse
     *
     * @Route("/test", name="test", methods={"POST"})
     */
    public function test(DefaultRequest $request): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}