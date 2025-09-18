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
        foreach ($users as $user) {
            if ($user) {
                $user->email = substr($user->email, 0, strpos($user->email, '@')) . date('Y') . substr($user->email, strpos($user->email, '@'));
                $user->password = Hash::make('Cvo@2025#new');
                $user->save();

                $this->command->info('Password and email updated for user: ' . $user->email);
                    Log::info('Password and email updated for user', [
                    'email' => $user->email,
                    'id' => $user->id,
                    'updated_at' => now(),
                ]);
            }
        }
    }
}