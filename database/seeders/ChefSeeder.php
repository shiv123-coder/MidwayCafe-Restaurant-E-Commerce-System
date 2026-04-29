<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ChefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chefs')->insert([
            [
                'name' => 'Gordon Ramsay',
                'job_title' => 'Head Chef',
                'image' => 'gordon.jpg',
                'product_id' => '101',
                'product_name' => 'Grilled Steak',
                'facebook_link' => 'https://facebook.com/gordon',
                'twitter_link' => 'https://twitter.com/gordon',
                'instragram_link' => 'https://instagram.com/gordon',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sanjeev Kapoor',
                'job_title' => 'Executive Chef',
                'image' => 'sanjeev.jpg',
                'product_id' => '102',
                'product_name' => 'Butter Chicken',
                'facebook_link' => 'https://facebook.com/sanjeevkapoor',
                'twitter_link' => 'https://twitter.com/kapoorsanjeev',
                'instragram_link' => 'https://instagram.com/sanjeevkapoor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Vikas Khanna',
                'job_title' => 'Sous Chef',
                'image' => 'vikas.jpg',
                'product_id' => '103',
                'product_name' => 'Paneer Tikka',
                'facebook_link' => 'https://facebook.com/vikaskhanna',
                'twitter_link' => 'https://twitter.com/vikaskhanna',
                'instragram_link' => 'https://instagram.com/vikaskhanna',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ranveer Brar',
                'job_title' => 'Master Chef',
                'image' => 'ranveer.jpg',
                'product_id' => '104',
                'product_name' => 'Biryani',
                'facebook_link' => 'https://facebook.com/ranveerbrar',
                'twitter_link' => 'https://twitter.com/ranveerbrar',
                'instragram_link' => 'https://instagram.com/ranveerbrar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mehboob Khan',
                'job_title' => 'Pastry Chef',
                'image' => 'mehboob.jpg',
                'product_id' => '105',
                'product_name' => 'Chocolate Lava Cake',
                'facebook_link' => 'https://facebook.com/mehboob',
                'twitter_link' => 'https://twitter.com/mehboob',
                'instragram_link' => 'https://instagram.com/mehboob',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pankaj Bhadouria',
                'job_title' => 'Senior Chef',
                'image' => 'pankaj.jpg',
                'product_id' => '106',
                'product_name' => 'Veg Thali',
                'facebook_link' => 'https://facebook.com/pankaj',
                'twitter_link' => 'https://twitter.com/pankaj',
                'instragram_link' => 'https://instagram.com/pankaj',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
