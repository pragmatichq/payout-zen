<?php

namespace App\Filament\Resources;

use App\Enums\AccountFormatTypeEnum;
use App\Filament\Resources\AccountFormatResource\Pages\CreateAccountFormat;
use App\Filament\Resources\AccountFormatResource\Pages\EditAccountFormat;
use App\Filament\Resources\AccountFormatResource\Pages\ListAccountFormats;
use App\Filament\Resources\AccountFormatResource\RelationManagers;
use App\Models\AccountFormat;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class AccountFormatResource extends Resource
{
    protected static ?string $model = AccountFormat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('firm_id')
                    ->relationship('firm', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(AccountFormatTypeEnum::class)
                    ->required(),
                MoneyInput::make('starting_balance')
                    ->required()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firm.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                MoneyColumn::make('starting_balance')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultGroup('firm.name')
            ->groups([
                Group::make('firm.name')
                    ->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccountFormats::route('/'),
            'create' => CreateAccountFormat::route('/create'),
            'edit' => EditAccountFormat::route('/{record}/edit'),
        ];
    }
}
