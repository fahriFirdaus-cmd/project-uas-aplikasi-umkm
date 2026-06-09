<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | QTY
            |--------------------------------------------------------------------------
            */

            if (!Schema::hasColumn('transactions', 'qty')) {

                $table->integer('qty')->default(1);

            }

            /*
            |--------------------------------------------------------------------------
            | TOTAL HARGA
            |--------------------------------------------------------------------------
            */

            if (!Schema::hasColumn('transactions', 'total_harga')) {

                $table->bigInteger('total_harga')->nullable();

            }

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            if (!Schema::hasColumn('transactions', 'status')) {

                $table->string('status')->nullable();

            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};