<?php

namespace App\Filament\Resources\TradingSessionResource\Pages;

use App\Filament\Resources\TradingSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTradingSession extends EditRecord
{
    protected static string $resource = TradingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
