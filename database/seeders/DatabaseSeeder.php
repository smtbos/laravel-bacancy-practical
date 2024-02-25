<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userDetails = [
            ['name' => 'Smit', 'email' => 'smtbos@gmail.com', 'password' => bcrypt('password')],
        ];

        $productDetails = [
            [
                'name' => 'Wafer',
                'lots' => [
                    ['quantity' => 5, 'expiry_date' => '2024-02-25'],
                    ['quantity' => 8, 'expiry_date' => '2024-02-29'],
                    ['quantity' => 6, 'expiry_date' => '2024-03-15'],
                ]
            ],
            [
                'name' => 'Chocolate',
                'lots' => [
                    ['quantity' => 81, 'expiry_date' => '2024-03-03'],
                    ['quantity' => 10, 'expiry_date' => '2024-03-24'],
                    ['quantity' => 45, 'expiry_date' => '2024-05-15'],
                ]
            ],
            [
                'name' => 'Biscuit',
                'lots' => [
                    ['quantity' => 100, 'expiry_date' => '2024-03-24'],
                    ['quantity' => 16, 'expiry_date' => '2024-05-15'],
                ]
            ],
            [
                'name' => 'Candy',
                'lots' => [
                    ['quantity' => 8, 'expiry_date' => '2024-04-01'],
                    ['quantity' => 6, 'expiry_date' => '2024-03-14'],
                ]
            ],
            [
                'name' => 'Chips',
                'lots' => [
                    ['quantity' => 7, 'expiry_date' => '2024-03-03'],
                    ['quantity' => 45, 'expiry_date' => '2024-06-01'],
                    ['quantity' => 33, 'expiry_date' => '2024-05-15'],
                ]
            ],
            [
                'name' => 'Coke',
                'lots' => [
                    ['quantity' => 78, 'expiry_date' => '2024-04-03'],
                    ['quantity' => 4, 'expiry_date' => '2024-02-24'],
                ]
            ]
        ];

        foreach ($userDetails as $userDetail) {
            $user = User::firstOrCreate([
                'email' => $userDetail['email']
            ], $userDetail);

            foreach ($productDetails as $productDetail) {
                $product = $user->products()->firstOrCreate([
                    'name' => $productDetail['name']
                ]);

                $product->lots()->delete();

                foreach ($productDetail['lots'] as $lot) {
                    $product->lots()->create([
                        'user_id' => $user->id,
                        'quantity' => $lot['quantity'],
                        'expiry_date' => $lot['expiry_date']
                    ]);
                }
            }
        }
    }
}
