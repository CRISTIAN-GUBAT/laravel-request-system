<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $studentA = User::where('email', 'student_a@example.com')->first();
        $studentB = User::where('email', 'student_b@example.com')->first();

        if ($studentA) {
            ServiceRequest::create([
                'user_id' => $studentA->id,
                'requester_name' => $studentA->name,
                'requester_email' => $studentA->email,
                'item_name' => 'Laptop',
                'quantity' => 1,
                'purpose' => 'For online classes and Capstone project',
                'status' => 'pending',
            ]);
        }

        if ($studentB) {
            ServiceRequest::create([
                'user_id' => $studentB->id,
                'requester_name' => $studentB->name,
                'requester_email' => $studentB->email,
                'item_name' => 'USB Flash Drive',
                'quantity' => 2,
                'purpose' => 'For storing project files',
                'status' => 'pending',
            ]);
        }
    }
}