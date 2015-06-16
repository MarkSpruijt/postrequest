<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Question;
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
        $this->call('QuestionTableSeeder');
	}

}


class UserTableSeeder extends Seeder {

	public function run()
	{
		User::create(['realname' => 'Docent A','username' => 'Docent', 'email' => 'docent@mydavinci.nl', 'password' => Hash::make('docent'), 'rank' => 100]);
		User::create(['realname' => 'Leerling A','username' => 'Leerling','email' => 'leerling@mydavinci.nl', 'password' => Hash::make('leerling')]);
	}
}

class QuestionTableSeeder extends Seeder {

    public function run()
    {
        Question::create(['title' => 'aardappel','content' => 'YOLO', 'user_id' => '1','created_at' => '0','updated_at' => '0']);
    }
}
