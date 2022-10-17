<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Stores\AddonOption;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\AddonOption>
 */
class AddonOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'name'              => $this->faker->word(3, true),
            'store_id'          => \App\Models\Stores\Store::all()->random()->id,
            'small_descriptions'  => $this->faker->sentence(1),
            'input_type_code'     => $this->faker->randomElement(['multichoice', 'singlechoice', 'limitedchoice']),
            'addon_type'          => $this->faker->randomElement(['add', 'remove']),
            'is_required'       => $this->faker->numberBetween(0, 1),
            'status'            => $this->faker->numberBetween(0, 1),
            'order_number'      => 0,
            'is_searchable'     => 1,
            'is_filterble'      => 1,   
            'min_select_numbers'    => 1,
            'max_select_numbers'    => $this->faker->numberBetween(1, 5),
        ];
    }
}
