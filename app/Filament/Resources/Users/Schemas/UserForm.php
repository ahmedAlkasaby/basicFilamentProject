<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
             
                TextInput::make('password')
                    ->password()
                    ->required(),
               
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
                Select::make('lang')
                    ->options(['en' => 'En', 'ar' => 'Ar'])
                    ->default('en')
                    ->required(),
                Select::make('theme')
                    ->options(['light' => __('site.light'), 'dark' => __('site.dark')])
                    ->default('light')
                    ->required(),
                Select::make('type')
                    ->options(['admin' => __('site.admin'), 'client' => __('site.client')])
                    ->default('admin')
                    ->required(),
                Select::make('roles')
                    ->label(__('site.roles'))
                    ->multiple() 
                    ->relationship('roles', 'name') 
                    ->preload() 
                    ->searchable(),
            ]);
    }
}
