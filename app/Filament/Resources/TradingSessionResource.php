<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TradingSessionResource\Pages;
use App\Filament\Resources\TradingSessionResource\RelationManagers;
use App\Models\TradingSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TradingSessionResource extends Resource
{
    protected static ?string $model = TradingSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'nickname')
                    ->required(),
                Forms\Components\TextInput::make('pnl')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account.nickname')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pnl')
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
            'index' => Pages\ListTradingSessions::route('/'),
            'create' => Pages\CreateTradingSession::route('/create'),
            'edit' => Pages\EditTradingSession::route('/{record}/edit'),
        ];
    }
}
