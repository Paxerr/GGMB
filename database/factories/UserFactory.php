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
            'Role' => fake()->randomElement(['MANAGER', 'SUPPORT', 'TECHNICIAN', 'SECURITY', 'RESIDENT']),
            'Department' => fake()->randomElement(['Ban quản lý', 'Chăm sóc cư dân', 'Kỹ thuật', 'An ninh', null]),
            'Status' => 'ACTIVE',
            'remember_token' => Str::random(10),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
