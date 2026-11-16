<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['has_variants']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncVariantSummary();
    }

    protected function syncVariantSummary(): void
    {
        $variants = $this->record->variants();

        if (! $variants->exists()) {
            return;
        }

        $this->record->update([
            'base_price' => $variants->min('price'),
            'stock' => $variants->sum('stock'),
            'sale_price' => null,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
