<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PresenterCollectionInterface;
use App\Contracts\PresenterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use ValidatesRequests;

    protected function successResponse(array $data, int $status = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse(['data' => $data], $status);
    }

    protected function emptyResponse(int $status = JsonResponse::HTTP_NO_CONTENT): JsonResponse
    {
        return new JsonResponse(null, $status);
    }

    protected function errorResponse(string $message, int $status = JsonResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse([
            'error' => [
                'http_code' => $status,
                'message' => $message
            ]
        ], $status);
    }

    public function createPaginatedResponse(
        LengthAwarePaginator $paginator,
        PresenterCollectionInterface $presenter
    ): JsonResponse {
        return new JsonResponse([
            'data' => $presenter->presentCollection(collect($paginator->items())),
            'meta' => [
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage()
            ]
        ]);
    }
}
