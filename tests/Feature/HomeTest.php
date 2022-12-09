<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function test_user_is_loggdin_and_dont_have_admin_with_same_id_user()
    {
        $user = User::factory()->create();

        $tokenResult = $user->createToken('Personal Access Token');

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $tokenResult->accessToken,
        ]);

        $response->assertJson([
            'user' => true,
            'admin' => false,
        ])->assertStatus(200);
    }

    public function test_user_is_loggdin_and_have_admin_with_same_id_user()
    {
        $user = User::factory()->create();

        Admin::factory()->create();

        $tokenResult = $user->createToken('Personal Access Token');

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $tokenResult->accessToken,
        ]);

        $response->assertJson([
            'user' => true,
            'admin' => true,
        ]);
    }
}
