<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Membership;
use App\Models\Attendance;
use App\Models\MemberMembership;
use App\Models\TrainerAssignment;
use App\Models\Workout;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $new_Attendance = Attendance :: create ([
           'member_id' => 2,
           'workout_id' => 3,
           'attended_at' => '2024-02-10 11:00:00'
        ]);

        
         dd("Done");

        // $workout = Workout :: all();
        // dd($workout->toArray());
        
    }
}
