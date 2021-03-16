<?php

namespace Plank\MediaManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manager:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mixAdditions = self::getMixChanges();
        $this->info("Adding Mix configuration...");
        $filesystem = new Filesystem();

        if (strpos($filesystem->get(resource_path('../webpack.mix.js')), 'Plank Media Manager Asset Loading') === false) {
            $filesystem->prepend(resource_path('../webpack.mix.js'), "var path = require('path');");
            $filesystem->append(resource_path('../webpack.mix.js'), $mixAdditions);
        }


        $this->warn("Choosing yes for the following option will install Vue as it is a dependency for this package.");
        if ($this->choice("Would you like to install and compile your assets?", ['y', 'n'], 'y') == 'y') {

            $this->info("Adding NPM dependencies...");
            $this->updateNodePackages(function ($packages) {
                return [
                        'laravel-mix' => "^5.0.1",
                        'vue' => "^2.6.12",
                        'vue-i18n' => "^8.24.0",
                        'vue-moment' => "^4.1.0",
                        'vue-loader' => "^16.1.2",
                        '@vue/compiler-sfc' => '^3.0.5'
                    ] + $packages;
            });

            $this->info("Installing front-end dependencies...");
            $install = new Process(['npm', 'install']);
            $install->setTimeout(null);
            $install->setWorkingDirectory(base_path())->mustRun();

            $this->info("Building assets...");
            $buildLevel = config("app.env") == "production" ? "prod" : "dev";
            $runDev = new Process(["npm", "run", $buildLevel]);
            $runDev->setTimeout(null);
            $runDev->setWorkingDirectory(base_path())->mustRun();
        }

        $this->info("Done!");

        return 0;
    }


    /**
     * Update the "package.json" file.
     * Taken from laravel/jetstream.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    protected static function getMixChanges() {
        return "
/*
 |--------------------------------------------------------------------------
 | Plank Media Manager Asset Loading
 |--------------------------------------------------------------------------
 |
 | To easily load assets permanently into you application's build process
 | we add this configuration to mix which automatically pulls assets from the package
 | into the application.
 |
 */

mix.copy('vendor/plank/laravel-media-manager/resources/img/*', 'public/images')
    .sass('vendor/plank/laravel-media-manager/resources/sass/app.scss', 'public/css')
    .js('vendor/plank/laravel-media-manager/resources/js/app.js', 'public/js')
    .webpackConfig({
        resolve: {
            alias: {
                '@plank': path.resolve('vendor/plank')
            }
        }
    })
    ";
    }

}
