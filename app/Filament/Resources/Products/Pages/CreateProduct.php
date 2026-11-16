<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $hasVariants = (bool) ($data['has_variants'] ?? false);

        unset($data['has_variants']);

        if ($hasVariants) {
            // Giá và tồn kho sẽ được đồng bộ sau khi lưu biến thể.
            $data['base_price'] = 0;
            $data['sale_price'] = null;
            $data['stock'] = 0;
        }

        return $data;
    }

    protected function afterCreate(): void
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
}
