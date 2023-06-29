<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class FamilyQueryBuilder extends Builder
{
    public function applySearch(string $search)
    {
        $this->where('provider_name', 'like', '%' . $search . '%');

        return $this;
    }

    public function applySorting(array $sorting)
    {
        $this->orderBy(
            $sorting['col'] ?? 'created_at',
            $sorting['dir'] ?? 'desc'
        );

        return $this;
    }

    public function applyFilters(array $filters)
    {
        $availableColumns = Schema::getColumnListing('families');

        foreach ($filters as $key => $val) {
            if (!in_array($key, $availableColumns)) {
                continue;
            }

            $this->whereIn($key, explode(',', $val));
        }

        return $this;
    }
}
