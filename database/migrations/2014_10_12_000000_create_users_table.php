<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('role_id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('logins')->default(0);
            $table->boolean('is_active')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        $users = [
            [
                'first_name' => 'Sean Philip',
                'last_name' => 'Cruz',
                'role_id' => 1,
                'email' => 'seanphilipcruz@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('asdqwe123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'first_name' => 'Harwinder Singh',
                'last_name' => 'Johal',
                'role_id' => 2,
                'email' => 'harwindersinghjohal7@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('asdqwe123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('users')->insert($users);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
