<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nameOfOrganization');
            $table->text('eventDetail');
            $table->string('location');
            $table->date('date');
            $table->time('startTime')->change();
            $table->time('endTime')->change();
            $table->text('skills');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('events');
    }
};
