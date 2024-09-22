<?php

namespace App\Filament\Resources;

use App\Enums\AccountStatusEnum;
use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use App\Models\AccountFormat;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->hiddenOn('edit')
                    ->required(),
                Select::make('firm_id')
                    ->relationship('firm', 'name')
                    ->hiddenOn('edit')
                    ->live()
                    ->required(),
                Select::make('account_format_id')
                    ->relationship('account_format', 'name')
                    ->hiddenOn('edit')
                    ->options(fn(Get $get): Collection => AccountFormat::query()
                        ->where('firm_id', $get('firm_id'))
                        ->pluck('name', 'id'))
                    ->required(),
                TextInput::make('nickname')
                    ->required(),
                ToggleButtons::make('status')
                    ->options(AccountStatusEnum::class)
                    ->inline()
                    ->required()
                    ->hiddenOn('create'),
                Fieldset::make('Account format')
                    ->relationship('account_format')
                    ->hiddenOn('create')
                    ->schema([
                        MoneyInput::make('starting_balance')
                            ->disabled(),
                        MoneyInput::make('profit_goal')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('firm.name'),
                TextColumn::make('account_format.name'),
                TextColumn::make('account_format.type')
                    ->label('Account type')
                    ->badge(),
                TextColumn::make('nickname'),
                TextColumn::make('status')
                    ->badge(),
                MoneyColumn::make('pnl'),
                MoneyColumn::make('current_balance'),
                MoneyColumn::make('maximum_loss_limit'),
                MoneyColumn::make('drawdown_remaining'),
                MoneyColumn::make('drawdown_threshold'),
                MoneyColumn::make('account_format.profit_goal')
                    ->label('Profit goal'),
                TextColumn::make('profit_goal_progress')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
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
