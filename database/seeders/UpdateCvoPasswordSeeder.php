<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateCvoPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 'LIKE', 'Admin')->where('user_type', 'LIKE', 'District Officer')->get();
        foreach($users as $user){
            if ($user) {
                $user->password = Hash::make('cvo@001#new');
                $user->save();
                $this->command->info('Password updated for user: ' . $user->email);
                Log::info('Password updated for user', [
                    'email' => $user->email,
                    'id' => $user->id,
                    'updated_at' => now(),
                ]);
            }
        }
    }
}