<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    // $factory->define(Contact::class, function(Faker $faker))
    {
        return [
            'fullname' => $this->faker->lastName() . $this->faker->firstName(),
            'gender' => $this->faker->biasedNumberBetween($min = 1, $max = 2),
            'email' => $this->faker->unique()->safeEmail(),
            'postcode' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building_name' => $this->faker->name(),
            'opinion' => $this->faker->sentence()

        ];
    }
}
