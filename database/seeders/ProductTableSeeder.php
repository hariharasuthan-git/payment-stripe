<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        $faker = \Faker\Factory::create();
        foreach (range(1, 10) as $index)  {
            Product::create([
                'name' => $faker->country,
                'price' => $faker->numberBetween($min = 1, $max = 2),
                'description'=> $faker->paragraph($nb =8),
                'status' => 1
            ]);
        }

    }
}
