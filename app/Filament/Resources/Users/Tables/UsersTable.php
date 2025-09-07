<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('site.name')),
                TextColumn::make('email')
                    ->label(__('site.email'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('site.type'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('site.roles'))
                    ->badge()
                    ->separator(',')
                    ->color('success'),
                ToggleColumn::make('active')
                    ->label(__('site.status'))
                    ->sortable()
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('lang')
                    ->sortable()
                    ->label(__('site.lang')),
                SelectColumn::make('lang')
                    ->options([
                        'en' => 'En',
                        'ar' => 'Ar',
                    ])
                    ->label(__('site.lang')),
                SelectColumn::make('theme')
                    ->options([
                        'light' => __('site.light'),
                        'dark' => __('site.dark'),
                    ])
                    ->label(__('site.theme')),
               
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('site.created_at'))
                    ->toggleable(isToggledHiddenByDefault: true),
               
            ])
            ->filters([
               
                TernaryFilter::make('active')
                    ->label(__('site.status')),
                SelectFilter::make('type')
                    ->options([
                        'admin' => __('site.admin'),
                        'client' => __('site.client'),
                      
                    ])
                    ->label(__('site.type')),
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->multiple()
                    ->label(__('site.roles'))
                
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
