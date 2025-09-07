<?php

namespace App\Filament\Resources\Regions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class RegionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make(__('site.translations'))
                    ->tabs([
                        Tab::make(__('site.english'))
                            ->icon('heroicon-o-flag')
                            ->schema([
                                TextEntry::make('name.en')
                                    ->label(__('site.name_en')),
                            ]),
                        Tab::make(__('site.arabic'))
                            ->icon('heroicon-o-flag')
                            ->schema([
                                TextEntry::make('name.ar')
                                    ->label(__('site.name_ar')),
                            ]),
                    ])
                    ->columnSpanFull(),

                TextEntry::make('order_id')
                    ->numeric()
                    ->label(__('site.order_no')),

                IconEntry::make('active')
                    ->boolean()
                    ->label(__('site.status')),

                TextEntry::make('city.name')
                    ->label(__('site.city'))
                    ->getStateUsing(fn($record) => $record->city?->nameLang()),

                TextEntry::make('created_at')
                    ->label(__('site.created_at'))
                    ->dateTime('Y-m-d H:i'),

             
            ]);
    }
}
