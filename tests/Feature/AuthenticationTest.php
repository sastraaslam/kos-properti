<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_login_and_registration_pages(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Masuk ke akun Anda');
        $this->get(route('register'))->assertOk()->assertSee('Daftar akun baru');
    }

    public function test_registration_creates_a_hashed_password_and_authenticates_user(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Sastra Aslam',
            'email' => 'sastra@example.test',
            'password' => 'ruangkos123',
            'password_confirmation' => 'ruangkos123',
        ])->assertRedirect(route('assets.index'));

        $user = User::query()->where('email', 'sastra@example.test')->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertSame(User::ROLE_TENANT, $user->role);
        $this->assertTrue(Hash::check('ruangkos123', $user->password));
    }

    public function test_registration_validates_duplicate_email_and_password_confirmation(): void
    {
        User::factory()->create(['email' => 'sastra@example.test']);

        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Sastra Aslam',
                'email' => 'sastra@example.test',
                'password' => 'ruangkos123',
                'password_confirmation' => 'password-lain',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'email' => 'sastra@example.test',
            'password' => Hash::make('ruangkos123'),
        ]);

        $this->post(route('login.store'), [
            'email' => 'sastra@example.test',
            'password' => 'ruangkos123',
        ])->assertRedirect(route('assets.index'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertGuest();
    }

    public function test_invalid_credentials_and_guest_access_to_inventory_are_rejected(): void
    {
        User::factory()->create([
            'email' => 'sastra@example.test',
            'password' => Hash::make('ruangkos123'),
        ]);

        $this->post(route('login.store'), [
            'email' => 'sastra@example.test',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->get(route('assets.index'))
            ->assertRedirect(route('login'));
    }
}
