<?php

namespace App\Filament\Resources\Regions\Schemas;

use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class RegionForm
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

                Select::make('city_id')
                    ->label(__('site.city'))
                    ->relationship(
                        name: 'city',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn($query) => $query->active(),
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->nameLang())
                    ->searchable()
                    ->preload()
                    ->required()


            ]);
    }
}
