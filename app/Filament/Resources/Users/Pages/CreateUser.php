<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Notifications\NewAccountNotification;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $tempPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->tempPassword = Str::password(8, true, true, false, false);
        $data['password'] = Hash::make($this->tempPassword);
        $data['must_change_password'] = true;
        $data['email_verified_at'] = now();

        return $data;
    }

    protected function afterCreate(): void
    {
        // Determine correct login URL based on role
        $loginUrl = $this->record->hasRole('admin') 
            ? url('/admin/login') 
            : url('/login');

        $this->record->notify(new NewAccountNotification($this->tempPassword, $loginUrl));
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User Created')
            ->body('The user has been created and notified via email.');
    }
}
