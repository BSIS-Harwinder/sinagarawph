<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('cost');
            $table->string('size');
            $table->string('panels');
            $table->integer('savings');
            $table->timestamps();
        });

        $panels = [
            [
                'cost' => 8000,
                'size' => '1.5kwp',
                'panels' => '3',
                'savings' => 1700,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 150000,
                'size' => '3kwp',
                'panels' => '6',
                'savings' => 3500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 184000,
                'size' => '4kwp',
                'panels' => '8',
                'savings' => 4500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 212000,
                'size' => '5kwp',
                'panels' => '10',
                'savings' => 5500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 252000,
                'size' => '6kwp',
                'panels' => '12',
                'savings' => 6500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 290000,
                'size' => '7kwp',
                'panels' => '14',
                'savings' => 8000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 330000,
                'size' => '8kwp',
                'panels' => '16',
                'savings' => 9000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cost' => 400000,
                'size' => '10kwp',
                'panels' => '20',
                'savings' => 11000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('offers')->insert($panels);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
