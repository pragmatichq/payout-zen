<?php

namespace App\Filament\Resources;

use App\Enums\AccountStatusEnum;
use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('firm_id')
                    ->relationship('firm', 'name')
                    ->required(),
                Forms\Components\Select::make('account_format_id')
                    ->relationship('account_format', 'name')
                    ->required(),
                Forms\Components\Select::make('platform_id')
                    ->relationship('platform', 'name')
                    ->required(),
                Forms\Components\TextInput::make('nickname')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(AccountStatusEnum::class)
                    ->required(),
                Forms\Components\TextInput::make('pnl')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('starting_balance')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('current_balance')
                    ->required()
                    ->numeric(),
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
                Tables\Columns\TextColumn::make('pnl')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('starting_balance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_balance')
                    ->numeric()
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
            //
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
