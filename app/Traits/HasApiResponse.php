<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

trait HasApiResponse
{
    /**
     * Return a standardized paginated JSON response.
     */
    protected function paginatedResponse(LengthAwarePaginator $paginator, mixed $resourceCollection, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $resourceCollection,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ], $code);
    }
}
