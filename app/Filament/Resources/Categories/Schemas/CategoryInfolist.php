<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin danh mục')
                    ->description('Thông tin cơ bản và trạng thái của danh mục')
                    ->icon('heroicon-o-rectangle-stack')
                    ->schema([
                        TextEntry::make('category_id')
                            ->label('Mã danh mục')
                            ->copyable(),

                        TextEntry::make('name')
                            ->label('Tên danh mục'),

                        TextEntry::make('parent.name')
                            ->label('Danh mục cha')
                            ->placeholder('Danh mục gốc'),

                        TextEntry::make('status')
                            ->label('Trạng thái')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'active' => 'Hoạt động',
                                'inactive' => 'Ngừng hoạt động',
                                default => $state,
                            })
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'active' => 'success',
                                'inactive' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Thông tin liên quan')
                    ->description('Số lượng sản phẩm và danh mục cấp dưới')
                    ->schema([
                        TextEntry::make('products_count')
                            ->label('Số sản phẩm')
                            ->state(fn ($record) => $record->products()->count())
                            ->numeric(),

                        TextEntry::make('children_count')
                            ->label('Số danh mục con')
                            ->state(fn ($record) => $record->children()->count())
                            ->numeric(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Thời gian')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Ngày tạo')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Không có dữ liệu'),

                        TextEntry::make('updated_at')
                            ->label('Cập nhật lần cuối')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Không có dữ liệu'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
