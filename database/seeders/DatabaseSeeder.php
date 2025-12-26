<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            PortfolioSeeder::class,
            BlogSeeder::class,
            ContactInquirySeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}