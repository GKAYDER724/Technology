<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('primaryImage.image')
                    ->label('Ảnh')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->sortable()
                    ->badge(),

                TextColumn::make('base_price')
                    ->label('Giá gốc')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Tổng tồn kho')
                    ->numeric()
                    ->sortable()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'danger'),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Lọc theo danh mục'),
            ])
->recordActions([
    EditAction::make(),
    DeleteAction::make(),
]);
    }
}