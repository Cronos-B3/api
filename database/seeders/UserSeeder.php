<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\Upvote;
use App\Models\User;
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
       ->count(10)
       ->has(
           Post::factory()
               ->count(rand(1, 5))
               ->has(Like::factory()->count(rand(1,10)))
               ->has(Upvote::factory()->count(rand(1,10)))
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

