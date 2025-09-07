<?php

namespace App\Filament\Resources\TrashBuckets\Pages;

use App\Filament\Resources\TrashBuckets\TrashBucketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrashBucket extends EditRecord
{
    protected static string $resource = TrashBucketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
