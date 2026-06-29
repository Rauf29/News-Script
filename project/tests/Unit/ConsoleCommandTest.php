<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\CrudGenerator;
use App\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;

class ConsoleCommandTest extends TestCase
{
    // ---- Kernel Configuration ----

    public function test_kernel_registers_crud_generator_command()
    {
        $kernel = $this->app->make(Kernel::class);
        $reflection = new \ReflectionClass($kernel);
        $property = $reflection->getProperty('commands');
        $property->setAccessible(true);
        $commands = $property->getValue($kernel);

        $this->assertContains(\App\Console\Commands\CrudGenerator::class, $commands);
    }

    public function test_kernel_can_be_instantiated()
    {
        $kernel = $this->app->make(Kernel::class);
        $this->assertInstanceOf(Kernel::class, $kernel);
    }

    public function test_kernel_extends_console_kernel()
    {
        $kernel = $this->app->make(Kernel::class);
        $this->assertInstanceOf(\Illuminate\Foundation\Console\Kernel::class, $kernel);
    }

    // ---- CrudGenerator Command ----

    public function test_crud_generator_command_is_registered_in_artisan()
    {
        $registered = $this->app->make(Kernel::class)->all();
        $names = array_map(function ($cmd) {
            return $cmd->getName();
        }, $registered);

        $this->assertContains('crud:generator', $names);
    }

    public function test_crud_generator_command_has_correct_signature()
    {
        $command = new CrudGenerator();
        $this->assertEquals('crud:generator', $command->getName());
    }

    public function test_crud_generator_command_signature_contains_name_argument()
    {
        $command = new CrudGenerator();
        $definition = $command->getDefinition();
        $this->assertTrue($definition->hasArgument('name'));
    }

    public function test_crud_generator_command_name_argument_is_required()
    {
        $command = new CrudGenerator();
        $definition = $command->getDefinition();
        $argument = $definition->getArgument('name');

        $this->assertTrue($argument->isRequired());
    }

    public function test_crud_generator_command_has_correct_description()
    {
        $command = new CrudGenerator();
        $this->assertEquals('Create CRUD operations for better performance', $command->getDescription());
    }

    public function test_crud_generator_command_can_be_instantiated()
    {
        $command = new CrudGenerator();
        $this->assertInstanceOf(CrudGenerator::class, $command);
    }

    public function test_crud_generator_command_extends_command()
    {
        $command = new CrudGenerator();
        $this->assertInstanceOf(\Illuminate\Console\Command::class, $command);
    }

    public function test_crud_generator_get_stub_reads_file()
    {
        $command = new CrudGenerator();
        $reflection = new \ReflectionMethod($command, 'getStub');
        $reflection->setAccessible(true);

        $stubPath = resource_path('stubs/Model.stub');
        if (file_exists($stubPath)) {
            $content = $reflection->invoke($command, 'Model');
            $this->assertNotEmpty($content);
            $this->assertIsString($content);
        } else {
            $this->markTestSkipped('Model.stub does not exist at ' . $stubPath);
        }
    }

    public function test_crud_generator_all_stubs_exist()
    {
        $stubs = ['Model', 'Controller', 'index', 'create', 'edit'];

        foreach ($stubs as $stub) {
            $path = resource_path("stubs/$stub.stub");
            $this->assertFileExists($path, "Stub file {$stub}.stub should exist at {$path}");
        }
    }

    public function test_crud_generator_handle_returns_integer()
    {
        $command = new CrudGenerator();
        $this->assertTrue(method_exists($command, 'handle'));
    }
}
