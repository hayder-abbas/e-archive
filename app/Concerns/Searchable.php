<?php

namespace App\Concerns;

use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait Searchable
{
    protected static function getResources(SearchRequest $request, Builder $query): ResourceCollection
    {
        $filters = $request->validated();
        $page = max(1, $request->integer('page', 1));

        $name       = $filters['name'] ?? null;
        $number     = $filters['number'] ?? null;
        $from       = $filters['fromDate'] ?? null;
        $to         = $filters['toDate'] ?? null;
        $typeFilter = $filters['typeFilter'] ?? null;

        return $query
            ->when(filled($name), fn($q) => $q->where('name', 'LIKE', "%{$name}%"))
            ->when(filled($number), fn($q) => $q->where('number', $number))
            ->when(filled($from), fn($q) => $q->where('date', '>=', $from))
            ->when(filled($to), fn($q) => $q->where('date', '<=', $to))
            ->when(
                filled($typeFilter) && $typeFilter !== 'all',
                fn($q) => $q->where('type', $typeFilter)
            )
            ->latest('id')
            ->paginate(20, page: $page)
            ->withQueryString()
            ->toResourceCollection();
    }
}
