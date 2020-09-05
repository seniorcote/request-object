<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Examples\App;

use Seniorcote\RequestObject\Examples\Request\DefaultRequest;
use Seniorcote\RequestObject\Examples\Request\Nested\FirstLevelObject;
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
     * @Route("/single-object", name="singleObject", methods={"POST"})
     */
    public function singleObject(DefaultRequest $request): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }

    /**
     * @param FirstLevelObject $request
     *
     * @return JsonResponse
     *
     * @Route("/nested-objects", name="nestedObjects", methods={"POST"})
     */
    public function nestedObjects(FirstLevelObject $request): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}