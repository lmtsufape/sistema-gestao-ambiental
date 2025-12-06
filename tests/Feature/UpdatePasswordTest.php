<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
        // Adicionando 'role' => 1 ao criar o usuário
        $this->actingAs($user = User::factory()->create(['role' => 1]));

        Livewire::test(UpdatePasswordForm::class)
                ->set('state', [
                    'current_password' => 'password',
                    'password' => 'Newpass1!',
                    'password_confirmation' => 'Newpass1!',
                ])
                ->call('updatePassword');

        $this->assertTrue(Hash::check('Newpass1!', $user->fresh()->password));
    }

    public function test_current_password_must_be_correct()
    {
        // Adicionando 'role' => 1 ao criar o usuário
        $this->actingAs($user = User::factory()->create(['role' => 1]));

        Livewire::test(UpdatePasswordForm::class)
                ->set('state', [
                    'current_password' => 'wrong-password',
                    'password' => 'Newpass1!',
                    'password_confirmation' => 'Newpass1!',
                ])
                ->call('updatePassword')
                ->assertHasErrors(['current_password']);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_new_passwords_must_match()
    {
        // Adicionando 'role' => 1 ao criar o usuário
        $this->actingAs($user = User::factory()->create(['role' => 1]));

        Livewire::test(UpdatePasswordForm::class)
                ->set('state', [
                    'current_password' => 'password',
                    'password' => 'Newpass1!',
                    'password_confirmation' => 'Wrongpass1!',
                ])
                ->call('updatePassword')
                ->assertHasErrors(['password']);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
