<?php

use App\Enums\AccountDrawdownTypeEnum;
use App\Enums\AccountFormatTypeEnum;
use App\Models\Firm;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_formats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Firm::class)->constrained();
            $table->string('name');
            $table->enum('type', AccountFormatTypeEnum::values())->default(AccountFormatTypeEnum::Evaluation->value);
            $table->enum('drawdown_type', AccountDrawdownTypeEnum::values())->default(AccountDrawdownTypeEnum::EOD->value);
            $table->bigInteger('drawdown_threshold')->nullable();
            $table->bigInteger('starting_balance')->default(0);
            $table->bigInteger('profit_goal')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_formats');
    }
};
