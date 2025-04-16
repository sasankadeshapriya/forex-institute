<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Billing;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Billing::create([
            'user_id' => 2,
            'address' => '123 Main Street',
            'city' => 'New York',
            'postal_code' => '10001',
            'phone_number' => '1234567890',
        ]);
    }
}
