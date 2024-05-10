<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reasons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        $data = [
            [
                'code' => "UNFAV_WEATHER",
                'description' => "Unfavorable weather conditions, heavy rain can make it unsafe or inconvenient to conduct the site visit. We request to reschedule your site visit date to ensure everyone's safety.",
                'created_at' => Carbon::now(),
            ],
            [
                'code' => "UNEXP_LOGISTICS",
                'description' => "Unexpected logistical challenges, transportation delays and equipment malfunctions happened causing the rescheduling the date of site visit. We are requesting to reschedule your site visit date to accommodate everyone's availability.",
                'created_at' => Carbon::now(),
            ],
            [
                'code' => "SCHED_CONFLICT",
                'description' => "Conflicts in schedules among our team members involved in the site visit can, We are requesting to  reschedule your site visit date to accommodate everyone's availability.",
                'created_at' => Carbon::now(),
            ],
            [
                'code' => "SAFETY_CONCERNS",
                'description' => "Safety concerns at the site, Ongoing construction and unstable conditions at the site, We request  to reschedule your site visit date to ensure the safety of everyone involved.",
                'created_at' => Carbon::now(),
            ]
        ];

        DB::table('reasons')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reasons');
    }
}
