<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        Campaign::factory()->count(10)->create([
            'email_list_id' => EmailList::query()->inRandomOrder()->first()->id,
            'template_id' => Template::query()->inRandomOrder()->first()->id,
        ]);
    }
}
