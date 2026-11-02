<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;

class Search
{
    public static function apply(
        Builder $query,
        ?string $keyword,
        array $columns
    ): Builder {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($keyword, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%{$keyword}%");
            }
        });
    }
}
