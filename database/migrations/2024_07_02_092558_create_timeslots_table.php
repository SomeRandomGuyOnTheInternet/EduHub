<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->id('timeslot_id');
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->date('meeting_date');
            $table->enum('timeslot', ['09:00', '11:00', '13:00', '15:00', '17:00']);
            $table->boolean('is_booked')->default(false);
            $table->timestamps();

            // Adding foreign key constraint
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
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
        Schema::dropIfExists('timeslots');
    }
}
