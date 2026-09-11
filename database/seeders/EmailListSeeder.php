<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class EmailListSeeder extends Seeder
{
    public function run(): void
    {
        EmailList::factory()->count(10)->create()
            ->each(function (EmailList $list) {
                Subscriber::factory()
                    ->count(rand(15, 30))
                    ->create(['email_list_id' => $list->id]);
            });
    }
}
