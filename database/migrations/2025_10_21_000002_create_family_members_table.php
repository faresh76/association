<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up()
{
Schema::create('family_members', function (Blueprint $table) {
    $table->bigIncrements('family_id');
    $table->unsignedBigInteger('member_id');
    $table->string('name', 100);
    $table->string('relationship', 50)->nullable();
    $table->date('date_of_birth')->nullable();
    $table->string('contact_no', 20)->nullable();
    $table->timestamps(); // created_at & updated_at

    $table->foreign('member_id')
          ->references('member_id')
          ->on('members')
          ->onDelete('cascade');
});
}


public function down()
{
Schema::dropIfExists('family_members');
}
};