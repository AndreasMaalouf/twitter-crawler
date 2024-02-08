<?php

use App\Enums\TwitterProfile\Priorities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('twitter_profiles', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('twitter_handle');
            $table->boolean('should_scrape')->default(true);
            $table->string('priority')->default(Priorities::Low->value);
            $table->timestamps();
        });

        DB::table('twitter_profiles')->insert([
            ['twitter_handle' => 'rektcapital', 'priority' => Priorities::Low->value],
            ['twitter_handle' => 'charliebilello', 'priority' => Priorities::Mid->value],
            ['twitter_handle' => 'eWhispers', 'priority' => Priorities::High->value],
            ['twitter_handle' => 'SeekingAlpha', 'priority' => Priorities::Mid->value],
            ['twitter_handle' => 'askjussi', 'priority' => Priorities::High->value],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitter_profiles');
    }
};
