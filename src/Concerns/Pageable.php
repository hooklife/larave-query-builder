<?php


namespace Hooklife\QueryBuilder\Concerns;


trait Pageable
{
    protected $prePage = 25;

    public function bootPageable($input)
    {
        if (isset($input['page']) && isset($input['size'])) {
            $this->query->forPage($input['page'], $input['size'] ?? $this->prePage);
        }
    }

}
