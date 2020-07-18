<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class customLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom_storage:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "admin/public/storage" to "storage/app/public"';

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
     * @return mixed
     */
    public function handle()
    {
        if (file_exists(public_path('storage'))) {
            return $this->error('The "public/storage" directory already exists.');
        }

        $this->laravel->make('files')->link(
            explode("storage", storage_path())[0] . 'admin\storage\app\public', public_path('storage')
        );

        $this->info('Короче, всё по кайфу, не кипишуй!');
    }
}
