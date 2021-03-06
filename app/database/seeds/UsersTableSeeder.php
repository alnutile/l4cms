<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
        DB::table('users')->truncate();
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $users = array(
            array(
                'firstname'  => 'Alfred',
                'lastname'  => 'Nutile',
                'admin'     => 1,
                'active'     => 1,
                'email'      => 'alfrednutile@gmail.com',
                'password'   => Hash::make('admin'),
                'created_at' => $dateTime,
                'updated_at' => $dateTime,
            ),
            array(
                'firstname'  => 'Test',
                'lastname'  => 'Two',
                'admin'     => 1,
                'active'     => 1,
                'email'      => 'test@gmail.com',
                'password'   => Hash::make('admin'),
                'created_at' => $dateTime,
                'updated_at' => $dateTime,
            ),
            array(
                'firstname'  => 'Test',
                'lastname'  => 'Three',
                'admin'     => 1,
                'active'     => 0,
                'email'      => 'test3@gmail.com',
                'password'   => Hash::make('admin'),
                'created_at' => $dateTime,
                'updated_at' => $dateTime,
            ),
        );
        DB::table('users')->insert( $users );
	}

}
