<?php

namespace App\Console\Commands;

use App\Classes\Matcher;
use App\Models\Accounts;
use App\Models\Contacts;
use App\Models\MatchingConfig;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class MatchingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matching:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Matching of contacts data and profiles';

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
     */
    public function handle()
    {
        $accounts = Accounts::all();
        $parameters = MatchingConfig::all();
        foreach ($accounts as $account){
            $newContacts = $account->contacts()->whereDate('created_at',Carbon::today())->get();
            $oldContacts = $account->contacts()->whereDate('created_at','<',Carbon::today())->get();
            foreach ($newContacts as $contact){
                $matcher = new Matcher();
                $matchedContact = $matcher->matchContact($contact,$oldContacts,$parameters);
                dd($matchedContact);
            }
        }
    }
}
