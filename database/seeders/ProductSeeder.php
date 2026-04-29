<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->truncate(); // optional reset

        $products = [
            [
                'name' => 'Chicken Biryani',
                'description' => 'Aromatic basmati rice with tender chicken pieces and spices.',
                'image' => 'images/chicken-biryani.jpg',
                'price' => 250,
                'category' => 'non-veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Paneer Tikka',
                'description' => 'Grilled paneer cubes marinated in spicy yogurt mix.',
                'image' => 'images/paneer-tikka.jpg',
                'price' => 180,
                'category' => 'veg',
                'session' => 1,
                'available' => true,
            ],
            [
                'name' => 'Cheese Burger',
                'description' => 'Double cheese burger with fresh veggies and sauce.',
                'image' => 'images/cheese-burger.jpg',
                'price' => 150,
                'category' => 'veg',
                'session' => 1,
                'available' => true,
            ],
            [
                'name' => 'Margherita Pizza',
                'description' => 'Classic pizza with tomato, mozzarella and basil.',
                'image' => 'images/margherita-pizza.jpg',
                'price' => 220,
                'category' => 'veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Butter Chicken',
                'description' => 'Creamy and rich butter chicken cooked in tomato gravy.',
                'image' => 'images/butter-masala.jpg',
                'price' => 280,
                'category' => 'non-veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Veg Thali Special',
                'description' => 'Complete Indian thali with multiple veg dishes.',
                'image' => 'images/veg-thali.jpg',
                'price' => 200,
                'category' => 'veg',
                'session' => 1,
                'available' => true,
            ],
            [
                'name' => 'Hakka Noodles',
                'description' => 'Stir-fried noodles with vegetables and sauces.',
                'image' => 'images/hakka-noodles.jpg',
                'price' => 160,
                'category' => 'veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Masala Dosa',
                'description' => 'Crispy dosa filled with spiced potato filling.',
                'image' => 'images/masala-dosa.jpg',
                'price' => 120,
                'category' => 'veg',
                'session' => 0,
                'available' => true,
            ],
            [
                'name' => 'Dal Makhani',
                'description' => 'Slow-cooked creamy black lentils.',
                'image' => 'images/dal-makhani.jpg',
                'price' => 140,
                'category' => 'veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Gulab Jamun',
                'description' => 'Soft milk-based sweet soaked in sugar syrup.',
                'image' => 'images/gulab-jamun.jpg',
                'price' => 90,
                'category' => 'veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Mutton Seekh Kebab',
                'description' => 'Spiced minced mutton grilled on skewers.',
                'image' => 'images/mutton-kebab.jpg',
                'price' => 300,
                'category' => 'non-veg',
                'session' => 2,
                'available' => true,
            ],
            [
                'name' => 'Chole Bhature',
                'description' => 'Spicy chickpeas with fluffy fried bread.',
                'image' => 'images/chole-bhature.jpg',
                'price' => 130,
                'category' => 'veg',
                'session' => 0,
                'available' => true,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'description' => $product['description'],
                'image' => $product['image'],
                'price' => $product['price'],
                'category' => $product['category'],
                'session' => $product['session'],
                'available' => $product['available'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
