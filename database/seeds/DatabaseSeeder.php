// database/seeds/DatabaseSeeder.php

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        $users = array(
                ['firstname' => 'Ryan', 'lastname' => 'Chenkie', 'password' => Hash::make('secret')],
                ['firstname' => 'Chris', 'lastname' => 'Sevilleja', 'password' => Hash::make('secret')],
                ['firstname' => 'Holly', 'lastname' => 'Lloyd', 'password' => Hash::make('secret')],
                ['firstname' => 'Adnan', 'lastname' => 'Kukic', 'password' => Hash::make('secret')],
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }

        Model::reguard();
    }
}