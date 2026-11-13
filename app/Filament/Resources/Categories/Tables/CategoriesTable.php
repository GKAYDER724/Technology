<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_id')
                    ->sortable()
                    ->label('ID'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Tên danh mục'),

                TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Đang hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->label('Trạng thái'),

                TextColumn::make('parent.name')
                    ->label('Danh mục cha')
                    ->badge()
                    ->color('info')
                    ->default('Danh mục gốc'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ]);
            // Đã gỡ bỏ hoàn toàn toolbarActions / bulkActions để giao diện sạch sẽ, không lỗi
    }
}