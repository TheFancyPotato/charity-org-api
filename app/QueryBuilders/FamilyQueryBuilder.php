<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class FamilyQueryBuilder extends Builder
{
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

            if (is_array($val)) {
                $this->whereIn($key, $val);
            } else {
                $this->where($key, $val);
            }
        }

        return $this;
    }
}
