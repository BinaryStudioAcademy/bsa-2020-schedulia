<?php

use Illuminate\Database\Seeder;
use \App\Entity\User;
use \App\Entity\EventType;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owners = User::all();

        $owners->map(
            function (User $owner) {
                return factory(EventType::class, 2)->create([
                    'owner_id' => $owner->id,
                    'disabled' => false,
                ]);
            }
        );
    }
}
