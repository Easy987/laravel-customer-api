<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'customer_code' => $this->faker->bothify('??###'),
            'contract_date' => $this->faker->date(),
        ];
    }
}
