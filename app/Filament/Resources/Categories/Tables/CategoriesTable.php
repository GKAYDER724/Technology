<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('category_id')
                    ->label('ID')
                    ->sortable(),


                TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('products_count')
                    ->label('Số sản phẩm')
                    ->counts('products')
                    ->badge()
                    ->color('info'),


                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'active' => 'Đang hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),


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
                ViewAction::make(),

                EditAction::make(),

                DeleteAction::make()
                    ->before(function ($record, DeleteAction $action) {

                        if ($record->products()->exists()) {

                            \Filament\Notifications\Notification::make()
                                ->title('Không thể xóa danh mục')
                                ->body('Danh mục này đang có sản phẩm.')
                                ->danger()
                                ->send();

                            $action->halt();
                        }
                    }),
            ]);
    }
}
