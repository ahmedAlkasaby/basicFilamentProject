<?php

namespace App\Filament\Resources\Cities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CitiesTable
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
                TextColumn::make('created_at')
                    ->label(__('site.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('regions_count')
                    ->counts('regions') 
                    ->label(__('site.regions_count'))
                    ->sortable(),

            ])
            ->defaultSort(fn($query) => $query->orderNo())

             ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('active')
                    ->label(__('site.status')),

               
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
