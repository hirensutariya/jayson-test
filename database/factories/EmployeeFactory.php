<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstNameMale,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->streetAddress,
            'department_id' => Department::count() ? Department::pluck('id')->random() : 1,
            'country_id' => 100,
            'state_id' => 1,
            'city_id' => 1,
            'zipcode' => 395010,
            'birthdate' => $this->faker->date,
            'date_hired' => $this->faker->date,
        ];
    }
}
