<?php

namespace App\Traits;

use App\CustomBuilders\SearchableBuilder;

trait Searchable
{

    /**
     * @param string $mapping
     *
     * @return array
     */
    public function parseRelationshipColumn(string $mapping): array
    {
        $segments = explode('.', $mapping);
        $column = array_pop($segments);
        $relations = implode('.', $segments);

        return [$relations, $column];
    }

    /**
     * @param $query
     * @return SearchableBuilder
     */
    public function newEloquentBuilder($query): SearchableBuilder
    {
        return new SearchableBuilder($query);
    }

    /**
     * @param array $columns
     * @return array
     */
    public function getSearchableColumns(array $columns): array
    {
        if (count($columns) === 0 && property_exists($this, 'searchable') && is_array($this->searchable)) {
            $columns = $this->searchable;
        }
        return $columns;
    }
}
