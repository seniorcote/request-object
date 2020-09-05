<?php

declare(strict_types=1);

namespace Seniorcote\RequestObject\Builder;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestObjectBuilder.
 */
interface RequestObjectBuilder
{
    /**
     * @param Request $request
     * @param object  $requestObject
     *
     * @return object
     */
    public function build(Request $request, object $requestObject): object;
}