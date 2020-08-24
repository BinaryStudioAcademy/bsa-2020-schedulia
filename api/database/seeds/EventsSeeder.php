<?php

use Illuminate\Database\Seeder;
use \App\Entity\EventType;
use \App\Entity\Event;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = EventType::all();

        $eventTypes->map(
            function (EventType $eventType) {
                return factory(Event::class, 10)->create([
                    'event_type_id' => $eventType->id,
                ]);
            }
        );
    }
}
