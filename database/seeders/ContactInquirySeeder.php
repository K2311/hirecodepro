<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some new inquiries
        ContactInquiry::factory()->count(5)->statusNew()->create();

        // Create some inquiries of different types
        ContactInquiry::factory()->count(3)->type('service')->create();
        ContactInquiry::factory()->count(2)->type('support')->create();
        ContactInquiry::factory()->count(2)->type('partnership')->create();

        // Create some inquiries with different statuses
        ContactInquiry::factory()->count(2)->state(['status' => 'read'])->create();
        ContactInquiry::factory()->count(2)->state(['status' => 'replied'])->create();
        ContactInquiry::factory()->count(1)->state(['status' => 'closed'])->create();
    }
}
