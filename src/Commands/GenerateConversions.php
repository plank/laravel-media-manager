<?php

namespace Plank\MediaManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Plank\MediaManager\Models\Media;
use Symfony\Component\Process\Process;

class GenerateConversions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media-manager:conversions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(Re)generate all conversions for all existing media items';

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
        $media = Media::all();
        foreach ($media as $m) {
            $m->save();
        }
        return 0;
    }


}
