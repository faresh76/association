<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('event_id');
            $table->string('event_name', 100);
            $table->date('event_date')->nullable();
            $table->string('location', 100)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('organized_by')->nullable(); // FK to committee_members.id

            $table->foreign('organized_by')
                  ->references('id')
                  ->on('committee_members')
                  ->onDelete('set null');

            $table->timestamps();
        });

        Schema::create('event_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('member_id');
            $table->boolean('attended')->default(false);

            $table->foreign('event_id')
                  ->references('event_id')
                  ->on('events')
                  ->onDelete('cascade');

            $table->foreign('member_id')
                  ->references('member_id')
                  ->on('members')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_participants');
        Schema::dropIfExists('events');
    }
};
