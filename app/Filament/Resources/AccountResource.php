<?php

namespace App\Filament\Resources;

use App\Enums\AccountStatusEnum;
use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use App\Models\AccountFormat;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('firm_id')
                    ->relationship('firm', 'name')
                    ->live()
                    ->required(),
                Select::make('account_format_id')
                    ->relationship('account_format', 'name')
                    ->options(fn(Get $get): Collection => AccountFormat::query()
                        ->where('firm_id', $get('firm_id'))
                        ->pluck('name', 'id'))
                    ->required(),
                Select::make('platform_id')
                    ->relationship('platform', 'name')
                    ->required(),
                TextInput::make('nickname')
                    ->required(),
                Select::make('status')
                    ->options(AccountStatusEnum::class)
                    ->required(),
                Group::make()->relationship('account_format')->schema([
                    MoneyInput::make('starting_balance')
                        ->disabled(),
                ]),
                MoneyInput::make('current_balance')
                    ->disabled(),
                MoneyInput::make('pnl')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('firm.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_format.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('platform.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nickname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                MoneyColumn::make('pnl')
                    ->sortable(),
                MoneyColumn::make('account_format.starting_balance')
                    ->sortable(),
                MoneyColumn::make('current_balance')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TradingSessionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
