<?php

namespace App\Console\Commands;

use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deletenewsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete newsletter after 2 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;

        $newsletter = Newsletter::whereDate('created_at', '<', Carbon::now()->subMinutes(2))
            ->delete();

        echo "Newsletter Delete!";

        // $newsletter = Newsletter::whereDate('deleted_at', '>', Carbon::now()->subMinutes(2))->restore();

    }
}
