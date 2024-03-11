<?php


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contest;
use App\Models\ContestDetails;
use App\Models\Participant;
use App\Models\Winner;
use App\Models\Payment;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(30)->create();
        Contest::factory()->count(50)->create();
        ContestDetails::factory()->count(50)->create();
        Participant::factory()->count(50)->create();
        Winner::factory()->count(50)->create();
        Payment::factory()->count(50)->create();
        Setting::factory()->count(10)->create();
    }
}
