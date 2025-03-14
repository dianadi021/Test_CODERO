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
        Schema::create('detail_project', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('project_lead');
            $table->string('client_name');
            $table->string('leader_photo')->nullable();
            $table->integer('project_progress');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('is_active')->default(1)->comment("0 Tidak, 1 Ya")->nullable();
            $table->integer('is_deleted')->default(0)->comment("0 Tidak, 1 Ya")->nullable();
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_project');
    }
};
