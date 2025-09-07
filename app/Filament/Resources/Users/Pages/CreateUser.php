<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;


     protected function afterCreate(): void
    {
        Notification::make()
    ->title('🎉 مستخدم جديد')
    ->body('تم إنشاء حساب جديد: ' . $this->record->name)
    ->success()
    ->sendToDatabase(User::where('type', 'admin')->get(),isEventDispatched: true);

        
    }
}
