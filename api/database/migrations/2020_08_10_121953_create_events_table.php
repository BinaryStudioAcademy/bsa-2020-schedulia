<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_type_id');
            $table->string('invitee_name');
            $table->string('invitee_email');
            $table->string('start_date');
            $table->string('timezone');
            $table->string('status')->default('scheduled');
            $table->timestamps();

            $table
                ->foreign('event_type_id')
                ->references('id')
                ->on('event_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
