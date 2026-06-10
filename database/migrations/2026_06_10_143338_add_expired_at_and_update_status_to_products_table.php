<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')->where('status', 'Available')->update(['status' => 'available']);
        DB::table('products')->where('sold', true)->where('status', '!=', 'sold')->update(['status' => 'sold']);

        Schema::table('products', function (Blueprint $table) {
            $table->string('status')->default('available')->change();
            $table->timestamp('expired_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('expired_at');
            $table->string('status')->default('Available')->change();
        });

        DB::table('products')->where('status', 'available')->update(['status' => 'Available']);
    }
};
