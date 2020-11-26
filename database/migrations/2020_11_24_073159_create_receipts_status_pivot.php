<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsStatusPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts_status', function (Blueprint $table) {


            $table->id();

            $table->boolean('status')->default(0);
            $table->text('notes')->nullable();


            $table->foreignId('receipts_id');
            $table->foreign('receipts_id')
                ->on('receipts')
                ->references('id')
                ->onDelete('CASCADE');


            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->onDelete('set null')
                ->on('users')
                ->references('id');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts_status', function (Blueprint $table) {
            //
        });
    }
}
