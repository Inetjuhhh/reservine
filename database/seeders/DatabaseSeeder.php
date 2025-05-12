<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DB::table('guests')->insert(array_map(function ($i) {
            return [
                'name' => "Guest $i",
                'telephone' => '06-1234567' . $i,
                'email' => "guest$i@example.com",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, range(1, 10)));

        // Tables
        DB::table('tables')->insert(array_map(function ($i) {
            return [
                'number' => $i,
                'couverts' => rand(2, 6),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, range(1, 10)));

        // Categories
        $categories = ['Borrel', 'Lunch', 'Diner'];
        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Subcategories
        $subcategories = ['Voorgerechten koud', 'Voorgerechten warm', 'Hoofdgerechten vis', 'Hoofdgerechten vlees', 'Hoofdgerechten Vega', 'Nagerecht', 'Borrelhapjes hartig', 'Borrelhapjes zoet', 'Drinken alcoholisch', 'Drinken non-alcoholisch'];
        foreach ($subcategories as $i => $name) {
            DB::table('subcategories')->insert([
                'name' => $name,
                'category_id' => ($i % 3) + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Meals
        $mealNames = ['Greek Salad', 'Tomato Soup', 'Spaghetti Bolognese', 'Grilled Salmon', 'Steak Frites', 'Vegan Burger', 'Cheesecake', 'Chocolate Lava Cake', 'White Wine', 'Mojito'];
        foreach ($mealNames as $i => $name) {
            DB::table('meals')->insert([
                'name' => $name,
                'description' => "Delicious $name",
                'image' => "storage/img/meal$i.jpg",
                'price' => number_format(mt_rand(50, 450) / 10, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Meal_Category & Meal_Subcategory
        foreach (range(1, 10) as $i) {
            DB::table('meal_category')->insert([
                'meal_id' => $i,
                'category_id' => ($i % 3) + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('meal_subcategory')->insert([
                'meal_id' => $i,
                'subcategory_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Ingredients
        $ingredients = ['Tomato', 'Lettuce', 'Onion', 'Cucumber', 'Cheese', 'Beef', 'Chicken', 'Basil', 'Garlic', 'Olive Oil'];
        foreach ($ingredients as $name) {
            DB::table('ingredients')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Meal_Ingredients
        foreach (range(1, 10) as $mealId) {
            foreach ((array) $ingredients as $ingredient) {
                DB::table('meal_ingredient')->insert([
                    'meal_id' => $mealId,
                    'ingredient_id' => rand(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Reservations
        foreach (range(1, 10) as $i) {
            DB::table('reservations')->insert([
                'table_id' => rand(1, 10),
                'guest_id' => rand(1, 10),
                'number_of_guests' => rand(1, 6),
                'starts_at' => Carbon::now()->addDays($i)->addHours(rand(0, 23))->toDateTimeString(),
                'ends_at' => Carbon::now()->addDays($i)->addHours(2)->toDateTimeString(),
                'allergies' => rand(0, 1) ? 'Nuts, Gluten' : null,
                'arrived' => (bool)rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Reservation_Meal
        foreach (range(1, 10) as $i) {
            DB::table('reservation_meal')->insert([
                'reservation_id' => $i,
                'meal_id' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Reservation_Meal_Ingredients
        foreach (range(1, 10) as $i) {
            DB::table('reservation_meal_ingredient')->insert([
                'reservation_meal_id' => $i,
                'ingredient_id' => rand(1, 10),
                'action' => ['add', 'remove', 'replace'][rand(0, 2)],
                'replacement_ingredient' => rand(0, 1) ? 'Tomato' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        //add tenant to tenants table
        DB::table('tenants')->insert([
            'name' => 'Italine',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Settings
        $settings = [
            ['tenant_id' => 1, 'name' => 'number_of_tables', 'value' => '10']
        ];
        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'tenant_id' => $setting['tenant_id'],
                'name' => $setting['name'],
                'value' => $setting['value'],
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
