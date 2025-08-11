<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Building;
use App\Models\Organization;
use App\Models\Activity;
use App\Models\User;

class TestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Building $building, Organization $organization, Activity $activity, User $user)
    {
        $user->name = 'test';
        $user->email = 'test';
        $user->password = '123';
        $user->save();
        
        $building->setTestData();
        $organization->setTestData();
        $activity->setTestData();
        
    }
}
