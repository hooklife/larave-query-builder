<?php


namespace Hooklife\QueryBuilder\Console\Commands;

use Illuminate\Console\GeneratorCommand;


class MakeQueryBuilder extends GeneratorCommand
{
    protected $name = 'make:queryBuilder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new QueryBuilder';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'query-builder';


    protected function getStub()
    {
        return __DIR__ . '/../stubs/QueryBuilder.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . config('laravel-query-builder.namespace', '\QueryBuilders');
    }
}
