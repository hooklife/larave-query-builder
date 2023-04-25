<?php


namespace Hooklife\QueryBuilder\Concerns;


trait Sortable
{
    protected $sortPrefix = 'sort_';

    public function bootSortable($input)
    {
        if (!property_exists($this, 'simpleSorts')) {
            return;
        }
        foreach ($this->simpleSorts as $field => $sort) {
            if (is_numeric($field) && isset($input[$this->sortPrefix . $sort])) {
                $field = $sort;
                $sort = $input[$this->sortPrefix . $sort];
            }
            if (!in_array(strtolower($sort), ['desc', 'asc'])) {
                continue;
            }
            $this->query->orderBy($field, $sort);
        }
    }

}
