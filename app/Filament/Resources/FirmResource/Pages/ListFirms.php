<?php

namespace App\Filament\Resources\FirmResource\Pages;

use App\Filament\Resources\FirmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFirms extends ListRecords
{
    protected static string $resource = FirmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
