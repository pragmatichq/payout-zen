<?php

namespace App\Filament\Resources\AccountResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class TradingSessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sessions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->native(false)
                    ->unique(modifyRuleUsing: function (Unique $rule, $livewire) {
                        return $rule->where('account_id', $livewire->ownerRecord->id)->ignore($livewire->ownerRecord->id, 'account_id');
                    })
                    ->closeOnDateSelection(),
                MoneyInput::make('pnl')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                MoneyColumn::make('pnl')
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(function ($action) {
                    $action->getLivewire()->dispatch('refreshForm');
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function ($action) {
                    $action->getLivewire()->dispatch('refreshForm');
                }),
                Tables\Actions\DeleteAction::make()->after(function ($action) {
                    $action->getLivewire()->dispatch('refreshForm');
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
