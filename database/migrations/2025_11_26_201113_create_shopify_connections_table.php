<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shopify_connections', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('status');
            $table->string('url')->unique();
            $table->string('access_token');
            $table->string('scope')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shopify_connections');
    }
};
