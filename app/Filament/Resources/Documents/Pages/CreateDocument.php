<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Document created')
            ->body('Document has been created successfully.')
            ->success();    
    }
}
