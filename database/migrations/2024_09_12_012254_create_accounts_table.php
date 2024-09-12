<?php

use App\Enums\AccountStatusEnum;
use App\Models\AccountFormat;
use App\Models\Firm;
use App\Models\Platform;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Firm::class)->constrained();
            $table->foreignIdFor(AccountFormat::class)->constrained();
            $table->foreignIdFor(Platform::class)->constrained();
            $table->string('nickname');
            $table->enum('status', AccountStatusEnum::values())->default(AccountStatusEnum::Active);
            $table->bigInteger('pnl')->default(0);
            $table->bigInteger('starting_balance');
            $table->bigInteger('current_balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
