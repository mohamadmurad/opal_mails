<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name');
            $table->unsignedInteger('amount');
            $table->text('reason');
            $table->boolean('status')->default(0)->nullable();


            $table->foreignId('employee_id')->nullable();
            $table->foreign('employee_id')
                ->on('users')
                ->references('id')->onDelete('set null');


            $table->foreignId('company_id')->nullable();
            $table->foreign('company_id')
                ->on('companies')
                ->references('id')->onDelete('set null');


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
        Schema::dropIfExists('receipts');
    }
}
