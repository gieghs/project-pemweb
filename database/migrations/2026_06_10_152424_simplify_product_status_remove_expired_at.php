<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')->where('status', 'pending_payment')->update(['status' => 'available']);
        DB::table('products')->where('status', 'reserved')->update(['status' => 'available']);

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('expired_at')->nullable()->after('status');
        });
    }
};