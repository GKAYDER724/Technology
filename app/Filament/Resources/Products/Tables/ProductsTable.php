<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn ($query) => $query->with('images')
            )
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Hình ảnh')
                    ->state(fn (Product $record) =>
                        $record->images->firstWhere('is_primary', true)?->image
                        ?? $record->images->first()?->image
                    )
                    ->disk('public')
                    ->square()
                    ->size(55),

                TextColumn::make('product_id')
                    ->label('Mã sản phẩm')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->placeholder('Chưa có danh mục'),

                TextColumn::make('base_price')
                    ->label('Giá gốc')
                    ->formatStateUsing(
                        fn ($state) => number_format(
                            (float) $state,
                            0,
                            ',',
                            '.'
                        ) . ' đ'
                    ),

                TextColumn::make('sale_price')
                    ->label('Giá khuyến mãi')
                    ->formatStateUsing(
                        fn ($state) => $state !== null
                            ? number_format(
                                (float) $state,
                                0,
                                ',',
                                '.'
                            ) . ' đ'
                            : 'Không giảm giá'
                    ),

                TextColumn::make('stock')
                    ->label('Tồn kho')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'hidden' => 'gray',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Đang kinh doanh',
                        'inactive' => 'Ngừng kinh doanh',
                        'hidden' => 'Đang ẩn',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->options(
                        DB::table('categories')
                            ->where('status', 'active')
                            ->pluck('name', 'category_id')
                            ->toArray()
                    ),

                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Đang kinh doanh',
                        'inactive' => 'Ngừng kinh doanh',
                        'hidden' => 'Đang ẩn',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem'),

                EditAction::make()
                    ->label('Chỉnh sửa'),
            ])
            ->toolbarActions([]);
    }
}
