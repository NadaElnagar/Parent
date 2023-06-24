<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{


    /** @test */
    public function it_can_list_all_users()
    {
        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
        $response->assertJsonCount(User::count(), 'data');
    }

    /** @test */
    public function it_can_filter_by_payment_provider()
    {
        $providerXUsersCount = User::whereHas('dataProviderX', function ($query) {
            $query->where('currency', 'USD');
        })->count();
    }

 }
