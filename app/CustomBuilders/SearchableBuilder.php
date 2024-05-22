<?php

namespace App\CustomBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\HigherOrderWhenProxy;

class SearchableBuilder extends Builder
{

    public function whenSearchRequest(Request $request, array $columns=[])
    {
        $columns = $this->model->getSearchableColumns($columns);

        return $this->whenSearch($request->input('search'), $columns);
    }

    /**
     * @param $search
     * @param array $columns
     *
     * @return mixed
     */
    public function whenSearch($search, array $columns=[]): mixed
    {
        $columns = $this->model->getSearchableColumns($columns);

        return $this->when($search, function($qry, $search) use ($columns){
            return $qry->search($search, $columns);
        });
    }

    /**
     * @param $query
     * @param array $columns
     *
     * @return Builder|SearchableBuilder
     */
    public function search($query, array $columns): Builder|SearchableBuilder
    {
        $subQuery = $this;

        foreach ($columns as $key=>$column){
            if (str_contains($column, '.')){
                [$relation, $column] = $this->model->parseRelationshipColumn($column);
                $subQuery = $key === 0 ? $this->whereSearchHas($query, $relation, $column) : $this->orWhereSearchHas($query, $relation, $column);
            }else{
                $subQuery = $key === 0 ? $this->whereSearch($query, $column )  : $this->orWhereSearch($query, $column );
            }
        }

        return $subQuery;
    }

    /**
     * @param $query
     * @param string $column
     *
     * @return SearchableBuilder
     */
    public function orWhereSearch($query, string $column): SearchableBuilder
    {
        return $this->orWhere($column, 'like', '%'.$query.'%');
    }

    /**
     * @param $query
     * @param string $column
     *
     * @return SearchableBuilder
     */
    public function whereSearch($query, string $column): SearchableBuilder
    {
        return $this->where($column, 'like', '%'.$query.'%');
    }

    /**
     * @param $query
     * @param string $relation
     * @param string $column
     *
     * @return SearchableBuilder|Builder
     */
    public function orWhereSearchHas($query, string $relation, string $column): Builder|SearchableBuilder
    {
        return $this->orWhere(function($qry) use($relation, $query, $column) {
            $qry->whereHas($relation, function($q) use ($query, $column){
                $q->where($column, 'like', '%'.$query.'%');
            });
        });

    }

    /**
     * @param $query
     * @param string $relation
     * @param string $column
     *
     * @return SearchableBuilder|Builder
     */
    public function whereSearchHas($query, string $relation, string $column): Builder|SearchableBuilder
    {
        return $this->whereHas($relation, function($q) use ($query, $column){
            $q->where($column, 'like', '%'.$query.'%');
        });
    }
}
