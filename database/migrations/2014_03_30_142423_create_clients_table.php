<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('mobile_number')->unique()->nullable();
            $table->string('alignment')->nullable(); // Explanation; status if the client is requesting quotation, setting site visit, and if done site visit
            $table->string('average_bill')->nullable();
            $table->string('bill')->nullable();
            $table->string('bill_status')->default('pending');
            $table->string('goal')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('date_joined')->default(Carbon::now());
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
        Schema::dropIfExists('clients');
    }
}
