<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'senha123'
        ]);

        EmailList::factory()
            ->count(10)
            ->create()
            ->each(function (EmailList $emailList) {
               Subscriber::factory()
                   ->count(rand(5, 10))
                   ->create(['email_list_id' => $emailList->id]);
            });
    }
}
