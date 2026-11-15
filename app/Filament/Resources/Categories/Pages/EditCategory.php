<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;


    protected function afterSave(): void
    {
        Notification::make()
            ->title('Cập nhật danh mục thành công')
            ->success()
            ->send();
    }


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->successNotificationTitle('Xóa danh mục thành công'),
        ];
    }
}
