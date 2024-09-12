<?php

namespace App\Filament\Resources\FirmResource\Pages;

use App\Filament\Resources\FirmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFirm extends EditRecord
{
    protected static string $resource = FirmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
