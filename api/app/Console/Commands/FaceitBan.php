<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FaceitBan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faceit:ban';

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
     * @return mixed
     */
    public function handle()
    {
        app('faceit.private')->cancelMatch('1-271576ad-0bab-4613-9735-68a63505f3a2');
    }
}
