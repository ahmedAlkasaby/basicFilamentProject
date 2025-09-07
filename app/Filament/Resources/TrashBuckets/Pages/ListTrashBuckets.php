<?php

namespace App\Filament\Resources\TrashBuckets\Pages;

use App\Filament\Resources\TrashBuckets\TrashBucketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrashBuckets extends ListRecords
{
    protected static string $resource = TrashBucketResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
        ];
    }
}
