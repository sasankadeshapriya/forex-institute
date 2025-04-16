<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'order_id' => 1,
            'payment_slip' => 'uploads/payment_slip_1.jpg',
            'status' => 'confirmed',
        ]);

        Payment::create([
            'order_id' => 2,
            'payment_slip' => 'uploads/payment_slip_2.jpg',
            'status' => 'pending',
        ]);
    }
}
