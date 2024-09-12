<?php

namespace App\Filament\Resources\AccountFormatResource\Pages;

use App\Filament\Resources\AccountFormatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountFormats extends ListRecords
{
    protected static string $resource = AccountFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
