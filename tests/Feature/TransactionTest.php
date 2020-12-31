<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Hash;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanTopupBalance() {
        $user = User::factory()->create();

        $payload = [
            'phone_number' => $user->phone_number,
            'bank_code' => 'bni',
            'amount' => 300000
        ];

        $response = $this->postJson('/api/transaction/topup', $payload);

        $response->assertStatus(200);
    }

    public function testUserCanAccessPageWithdraw()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/transaction/withdraw');

        $response->assertStatus(200);
    }

    public function testUserCanWithdraw() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->withSession(['banned' => false])
                        ->post('/transaction/withdraw-store', [
                            'bank_code' => 'bni',
                            'account_number' => '12112110',
                            'amount' => 50000, 
                        ]);

        $response->assertRedirect('/transaction/withdraw');
    }

    public function testUserCanAccessPageTransfer()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/transaction/transfer');

        $response->assertStatus(200);
    }

    public function testUserCanTransfer() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->withSession(['banned' => false])
                        ->post('/transaction/transfer-store', [
                            'phone_number' => $user->phone_number,
                            'amount' => 50000,
                            'description' => 'Uang jajan',
                        ]);

        $response->assertRedirect('/transaction/transfer');
    }
}
