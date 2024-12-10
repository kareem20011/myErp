<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class CraeteTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            Tenant::create([
                'name' => $faker->words(2, true),
                'phone' => $faker->numberBetween(11, 11),
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->sentence,
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }

        echo "Seeder executed successfully: Tenant granted to 'Tenants'.\n";
    }
}
