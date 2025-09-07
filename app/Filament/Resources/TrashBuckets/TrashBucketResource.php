<?php

namespace App\Filament\Resources\TrashBuckets;

use App\Filament\Resources\TrashBuckets\Pages\CreateTrashBucket;
use App\Filament\Resources\TrashBuckets\Pages\EditTrashBucket;
use App\Filament\Resources\TrashBuckets\Pages\ListTrashBuckets;
use App\Filament\Resources\TrashBuckets\Schemas\TrashBucketForm;
use App\Filament\Resources\TrashBuckets\Tables\TrashBucketsTable;
use App\Models\TrashBucket;
use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrashBucketResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = TrashBucket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

     public static function getPermissionPrefixes(): array
    {
        return [
            'view_any',
            'restore',
            'restore_any',
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('site.trash_buckets');
    }

    public static function getModelLabel(): string
    {
        return __('site.trash_bucket');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.trash_bucket');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema ;
    }

    public static function table(Table $table): Table
    {
        return TrashBucketsTable::configure($table);
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
            'index' => ListTrashBuckets::route('/'),
        
        ];
    }
}
