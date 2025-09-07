<?php

namespace App\Filament\Resources\Regions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RegionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('site.name'))
                    ->getStateUsing(fn($record) => $record->nameLang())
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('active')
                    ->label(__('site.status'))
                    ->sortable()
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('city.name')
                    ->label(__('site.city'))
                    ->getStateUsing(fn($record) => $record->city?->nameLang())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('site.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->searchable(),

            ])
            ->defaultSort(fn($query) => $query->orderNo())

            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('active')
                    ->label(__('site.status')),
                SelectFilter::make('city')
                    ->label(__('site.city'))
                    ->relationship(
                        name: 'city',
                        titleAttribute: 'id', 
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->nameLang())
                    ->searchable()
                    ->preload()



            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
