<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup cho website';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $source = 'default_file';
        $destination = storage_path('app/public/');

        if (\File::copyDirectory($source, $destination)) {
            $this->info('Setup successfully.');
        } else {
            $this->error('Failed setup.');
        }

        return 0;
    }
}
