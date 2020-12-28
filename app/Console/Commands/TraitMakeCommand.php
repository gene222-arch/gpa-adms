<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class TraitMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new trait';

    /**
     * Type of class being generated
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get the stub file for the generator
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/traits.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Traits';
    }
}
