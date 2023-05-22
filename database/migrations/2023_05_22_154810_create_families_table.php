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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('provider_phone');
            $table->tinyInteger('members_count', false, true)->nullable();
            $table->tinyInteger('youngers_count', false, true)->nullable();
            $table->tinyInteger('provider_social_status')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('income')->nullable();
            $table->tinyInteger('housing_type')->nullable();
            $table->unsignedInteger('rent_cost')->nullable();
            $table->unsignedInteger('shares_count', false, true)->nullable();
            $table->tinyInteger('income_type')->nullable();
            $table->text('other_orgs')->nullable();
            $table->text('notes')->nullable();
            $table->json('docs')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
