<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category_id')
                    ->label('ID danh mục'),

                TextEntry::make('name')
                    ->label('Tên danh mục'),

                TextEntry::make('parent.name')
                    ->label('Danh mục cha')
                    ->default('Danh mục gốc'),

                TextEntry::make('status')
                    ->label('Trạng thái')
                    ->badge(),

                TextEntry::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Cập nhật lần cuối')
                    ->dateTime(),
            ]);
    }
}