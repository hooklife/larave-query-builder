<?php


namespace Hooklife\QueryBuilder;


use Illuminate\Database\Eloquent\Builder;
use Str;

class QueryBuilder
{

    public array $whitelistInputs = [];
    public array $blacklistInputs = [];
    public array $allowEmptyInputs = [];


    public array $input = [];
    /**
     * @var Builder
     */
    public Builder $query;

    public function __construct($input, Builder $query)
    {
        $this->query = $query;
        $this->input = $input;
        $this->bootTraits();
        $this->boot($input, $query);
    }

    protected function boot(array $input, $query)
    {

    }

    public function bootTraits()
    {
        foreach (class_uses_recursive($this) as $trait) {
            if (method_exists($this, $method = 'boot' . class_basename($trait))) {
                $this->$method($this->input);
            }
        }
    }

    public function getQueryMethod($input)
    {
        return Str::camel($input);
    }

}
