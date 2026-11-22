<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'UserName' => fake()->unique()->userName(),
            'PasswordHash' => static::$password ??= Hash::make('password123'),
            'FullName' => fake()->name(),
            'Phone' => fake()->numerify('09########'),
            'Email' => fake()->unique()->safeEmail(),
            'CitizenId' => fake()->numerify('079000######'),
            'Role' => 'MANAGER',
            'Department' => 'Ban quản lý',
            'Status' => 'ACTIVE',
            'remember_token' => Str::random(10),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }

    public function manager(): static
    {
        return $this->state(fn () => [
            'Role' => 'MANAGER',
            'Department' => 'Ban quản lý',
        ]);
    }

    public function support(): static
    {
        return $this->state(fn () => [
            'Role' => 'SUPPORT',
            'Department' => 'Chăm sóc cư dân',
        ]);
    }

    public function technician(): static
    {
        return $this->state(fn () => [
            'Role' => 'TECHNICIAN',
            'Department' => 'Kỹ thuật',
        ]);
    }

    public function resident(): static
    {
        return $this->state(fn () => [
            'Role' => 'RESIDENT',
            'Department' => null,
        ]);
    }
}
