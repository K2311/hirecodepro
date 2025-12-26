<?php
// database/seeders/ClientSeeder.php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'email' => 'sarah@techscale.com',
                'full_name' => 'Sarah Johnson',
                'company' => 'TechScale Inc.',
                'position' => 'Founder',
                'phone' => '+1-555-0123',
                'status' => 'client',
                'tags' => ['saas', 'startup', 'recurring'],
            ],
            [
                'email' => 'michael@fashionforward.com',
                'full_name' => 'Michael Chen',
                'company' => 'FashionForward',
                'position' => 'CEO',
                'phone' => '+1-555-0124',
                'status' => 'client',
                'tags' => ['ecommerce', 'agency'],
            ],
            [
                'email' => 'david@startuphelper.com',
                'full_name' => 'David Rodriguez',
                'company' => 'StartupHelper',
                'position' => 'Founder',
                'phone' => '+1-555-0125',
                'status' => 'lead',
                'tags' => ['startup', 'non-technical'],
            ],
            [
                'email' => 'emily@digitalagency.com',
                'full_name' => 'Emily Wilson',
                'company' => 'Digital Agency Co.',
                'position' => 'Project Manager',
                'phone' => '+1-555-0126',
                'status' => 'client',
                'tags' => ['agency', 'multiple_projects'],
            ],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}