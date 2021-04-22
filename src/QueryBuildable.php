<?php


namespace Hooklife\QueryBuilder;


use Illuminate\Database\Eloquent\Builder;
use Str;

trait QueryBuildable
{

    /** @var QueryBuilder $queryBuilder */
    public $queryBuilder;
    public array $input;


    public function scopeQueryBuilder($query, array $input = [], $queryBuilder = null)
    {
        // Resolve the current Model's filter
        if ($queryBuilder === null) {
            $queryBuilder = $this->provideQueryBuilder();
        }
        // Create the model filter instance
        $this->queryBuilder = new $queryBuilder();
        $this->queryBuilder->boot($query, $this->removeEmptyInput($input));

        // Return the filter query
        return $this->handle();
    }

    private function handle()
    {
        foreach ($this->queryBuilder->input as $key => $val) {
            // Call all local methods on filter
            $method = $this->queryBuilder->getQueryMethod($key);
            if (method_exists($this->queryBuilder, $method)) {
                $this->queryBuilder->{$method}($val);
            }
        }

        return $this->queryBuilder->query;
    }


    private function isAllowedInput(string $key, $value): bool
    {
        if (in_array($key, $this->queryBuilder->allowEmptyInputs)) {
            return true;
        }

        if ($this->queryBuilder->whitelistInputs && !in_array($key, $this->queryBuilder->whitelistInputs)) {
            return false;
        }

        if ($this->queryBuilder->blacklistInputs && in_array($key, $this->queryBuilder->blacklistInputs)) {
            return false;
        }

        return $value !== '' && $value !== null && !(is_array($value) && empty($value));
    }

    private function removeEmptyInput(array $input): array
    {
        return array_filter(
            $input,
            fn($value, $key) => $this->isAllowedInput($key, $value),
            ARRAY_FILTER_USE_BOTH
        );
    }


    private function provideQueryBuilder($queryBuilder = null): ?string
    {
        if ($queryBuilder === null) {
            $queryBuilder = config('laravel-filter.namespace', 'App\\QueryBuilders\\') .
                class_basename($this) . 'QueryBuilder';
        }
        return $queryBuilder;
    }
}
