<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Créer 100 utilisateurs, chacun avec 10 posts et chaque post avec 10 commentaires
       User::factory()
       ->count(100)
       ->has(
           Post::factory()
               ->count(10)
               ->has(()->count(10))
       )
       ->create();

   // Récupérer tous les utilisateurs pour leur assigner des followers aléatoirement
   $users = User::all();

   // Pour chaque utilisateur, assigner des followers aléatoires
   foreach ($users as $user) {
       // Obtenir un sous-ensemble aléatoire d'utilisateurs comme followers
       $followers = $users->random(rand(1, 10));

       foreach ($followers as $follower) {
           // Éviter que l'utilisateur se suive lui-même
           if ($follower->id !== $user->id) {
               $user->followers()->attach($follower->id);
           }
       }
   }
}
    }

