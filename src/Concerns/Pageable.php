<?php


namespace Hooklife\QueryBuilder\Concerns;


trait Pageable
{
    public function bootPageable($input)
    {
        $config = config('laravel-query-builder.api_page');
        $skip = $input[$config['param']['skip']] ?? 0;
        $take = $input[$config['param']['take']] ?? $config['default_take'];
        $take = min($take, $config['max_take']);

        return $this->query->skip($skip)->take($take);
    }
}
