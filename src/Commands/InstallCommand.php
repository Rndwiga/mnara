<?php

namespace Tyondo\Mnara\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Tyondo\Mnara\Traits\Seedable;
use Tyondo\Mnara\MnaraServiceProvider;
use Tyondo\MenuGenerator\TyondoMenuGeneratorServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;

class InstallCommand extends Command
{
    use Seedable;

    protected $seedersPath = __DIR__.'/../Database/seeds/';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mnara:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Mnara User package';

    protected function getOptions()
    {
        return [
            ['with-dummy', null, InputOption::VALUE_NONE, 'Install with dummy data', null],
        ];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function fire(Filesystem $filesystem)
    {
        $this->info('Publishing the Mnara assets, database, and config files');
        $this->call('vendor:publish', ['--provider' => MnaraServiceProvider::class,
                                                    '--tag' => ['config','mnara_assets','seeds']
                                                ]);
        $this->call('vendor:publish', [
                                                '--provider' => TyondoMenuGeneratorServiceProvider::class,
                                                '--tag' => 'views'
                                                ]);
        $this->call('vendor:publish', [
                                                '--provider' => ActivitylogServiceProvider::class,
                                                '--tag' => ['config','migrations']
                                                ]);

        $this->info('Migrating the database tables into your application');
        $this->call('migrate');

        $this->info('Dumping the autoloaded files and reloading all new files');

        $composer = $this->findComposer();

        $process = new Process($composer.' dump-autoload -o');
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Adding Mnara routes to routes/web.php');
        $filesystem->append(
            base_path('routes/web.php'),
            "\n\nRoute::group(['prefix' => 'mnara'], function () {\n    Mnara::routes();\n});\n"
        );

        $this->info('Seeding data into the database');
        $this->seed('MnaraDatabaseSeeder');
    /*
        if ($this->option('with-dummy')) {
            //$this->seed('MnaraDatabaseSeeder');
        }
    */
        $this->info('Successfully installed Mnara! Enjoy 🎉');
    }
}
