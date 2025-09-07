<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make(__('site.translations'))
                ->tabs([
                    Tab::make(__('site.english'))
                        ->icon('heroicon-o-flag')
                        ->schema([
                            TextInput::make('name.en')
                                ->label(__('site.name_en'))
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    Tab::make(__('site.arabic'))
                        ->icon('heroicon-o-flag')
                        ->schema([
                            TextInput::make('name.ar')
                                ->label(__('site.name_ar'))
                                ->required()
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpanFull(),

            TextInput::make('latitude')
                ->numeric()
                ->label(__('site.latitude'))
                ->minValue(-90)
                ->maxValue(90)
                ->required(),

            TextInput::make('longitude')
                ->numeric()
                ->label(__('site.longitude'))
                ->minValue(-180)
                ->maxValue(180)
                ->required(),
            TextInput::make('redius_meter')
                ->numeric()
                ->label(__('site.redius_meter'))
                ->required()
                ->placeholder('500')
                ->columnSpan(1),

            TextInput::make('order_id')
                ->numeric()
                ->label(__('site.order_no'))
                ->columnSpan(1),
            Select::make('active')
                ->label(__('site.status'))
                ->options([
                    1 => __('site.active'),
                    0 => __('site.inactive'),
                ])
                ->default(1)
                ->required()
                ->searchable()
                ->placeholder(__('site.select_option'))
                ->columnSpan(1),

        ])
            ->columns(2);
    }
}
