<?php


namespace Hooklife\QueryBuilder\Concerns;


trait Filterable
{
    public function bootFilterable($input)
    {
        if (!property_exists($this, 'simpleFilters')) {
            return;
        }
        foreach ($this->simpleFilters as $field => $filter) {
            if (is_numeric($field)) {
                $field = $filter;
                $filter = ['=', '?'];
            }
            [$opera, $template] = $filter;
            if (!isset($input[$field])) {
                continue;
            }
            $value = str_replace('?', $input[$field], $template);
            $this->query->where($field, $opera, $value);
        }
    }
}
