<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->string('city');
            $table->string('country');
            $table->string('phone_1');
            $table->string('phone_2');
            $table->string('email');
            $table->date('subscription_date');
            $table->string('website');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('records');
    }
};
