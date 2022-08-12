<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $fashionStore = Store::factory(1)
        ->hasAttached(
            User::factory()->count(2)
            ->has(UserProfile::factory(1))
            ->create()->each(
                function($user){
                    $user->assignRole('book-owner');
                }
            )
        );

         User::factory()->count(2)
        ->has(UserProfile::factory(1))
        ->has($fashionStore)
        ->create()->each(
            function($user){
                $user->assignRole('book-owner');
            }
        );

        $luxuryPhonesStores = Store::factory(1)
                            ->hasAttached(
                                User::factory()->count(2)
                          ->has(UserProfile::factory(1))
                          ->create()->each(
                          function($user){
                            $user->assignRole('book-owner');
                        }
            )
                    );
                            
        $budgetPhonesStores = Store::factory(1)
             ->hasAttached(
                       User::factory()->count(2)
                      ->has(UserProfile::factory(1))
                      ->create()->each(
                      function($user){
                       $user->assignRole('book-owner');
                      }
)
);

        User::factory()->count(2)
        ->has(UserProfile::factory(1))
        ->has($luxuryPhonesStores)
        ->has($budgetPhonesStores)
        
        ->create()->each(
            function($user){
                $user->assignRole('book-owner');
            }
        );
    }
}
