<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('site.name'))
                    ->getStateUsing(fn($record) => $record->nameLang()) // يجيب على حسب لغة التطبيق
                    ->sortable()
                    ->searchable(),
                TextColumn::make('latitude')
                    ->label(__('site.latitude'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('longitude')
                    ->label(__('site.longitude'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('redius_meter')
                    ->label(__('site.redius_meter'))
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

            ])
            ->defaultSort(fn ($query) => $query->orderNo())



            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('active')
                    ->label(__('site.status')),

                SelectFilter::make('sort_by')
                    ->label(__('site.sort_by'))
                    ->options([
                        'newest'   => __('site.newest'),
                        'oldest'   => __('site.oldest'),
                        'order_no' => __('site.order_no'),
                    ]),
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
