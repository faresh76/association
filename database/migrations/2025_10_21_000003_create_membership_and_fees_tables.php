<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('membership_types', function (Blueprint $table) {
            $table->bigIncrements('type_id');
            $table->string('type_name', 50)->unique();
            $table->text('description')->nullable();
            $table->decimal('annual_fee', 10, 2)->nullable();
        });

        Schema::create('member_membership', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('type_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreign('member_id')
                  ->references('member_id')
                  ->on('members')
                  ->onDelete('cascade');

            $table->foreign('type_id')
                  ->references('type_id')
                  ->on('membership_types')
                  ->onDelete('cascade');
        });

        Schema::create('fees_payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('member_id');
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date')->useCurrent();
            $table->enum('payment_method', ['Cash', 'Online', 'Bank Transfer'])->nullable();
            $table->string('reference_no', 50)->nullable();
            $table->text('remarks')->nullable();

            $table->foreign('member_id')
                  ->references('member_id')
                  ->on('members')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees_payments');
        Schema::dropIfExists('member_membership');
        Schema::dropIfExists('membership_types');
    }
};
