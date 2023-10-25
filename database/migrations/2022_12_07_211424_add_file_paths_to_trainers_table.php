<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('mandatory_training_cert_1')->nullable()->after('dbs_renewal_date');
            $table->string('mandatory_training_cert_2')->nullable()->after('dbs_renewal_date');
            $table->string('mandatory_training_cert_3')->nullable()->after('dbs_renewal_date');
            $table->string('mandatory_training_cert_4')->nullable()->after('dbs_renewal_date');
            $table->string('mandatory_training_cert_5')->nullable()->after('dbs_renewal_date');
            $table->boolean('has_completed_mandatory_training')->default(0)->after('dbs_renewal_date');
            $table->string('dbs_cert_path')->nullable()->after('dbs_renewal_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainers', function (Blueprint $table) {
            //
        });
    }
};
