<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 2,
            'course_id' => 1,
            'amount' => 60.95,
            'status' => 'completed',
        ]);

        Order::create([
            'user_id' => 2,
            'course_id' => 2,
            'amount' => 100,
            'status' => 'processing',
        ]);
    }
}
