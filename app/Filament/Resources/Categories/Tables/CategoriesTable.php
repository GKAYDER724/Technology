<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn ($query) => $query
                    ->with('parent')
                    ->withCount(['products', 'children'])
            )
            ->columns([
                TextColumn::make('category_id')
                    ->label('Mã danh mục')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('parent.name')
                    ->label('Danh mục cha')
                    ->placeholder('Danh mục gốc')
                    ->sortable(),

                TextColumn::make('products_count')
                    ->label('Số sản phẩm')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('children_count')
                    ->label('Danh mục con')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                    ]),

                SelectFilter::make('parent_id')
                    ->label('Danh mục cha')
                    ->options(fn (): array => Category::query()
                        ->orderBy('name')
                        ->pluck('name', 'category_id')
                        ->all()),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),

                DeleteAction::make()
                    ->label('Xóa')
                    ->modalHeading('Xóa danh mục?')
                    ->modalDescription('Chỉ có thể xóa danh mục không chứa sản phẩm và không có danh mục con.')
                    ->failureNotificationTitle('Không thể xóa danh mục')
                    ->failureNotificationBody('Danh mục đang có sản phẩm hoặc danh mục con. Hãy xử lý dữ liệu liên quan trước khi xóa.')
                    ->using(function (Category $record): bool {
                        if (
                            $record->products()->exists() ||
                            $record->children()->exists()
                        ) {
                            return false;
                        }

                        return (bool) $record->delete();
                    }),

                Action::make('toggleStatus')
                    ->label(fn (Category $record): string =>
                        $record->status === 'active' ? 'Ẩn danh mục' : 'Hiện danh mục'
                    )
                    ->icon(fn (Category $record): string =>
                        $record->status === 'active' ? 'heroicon-o-eye-slash' : 'heroicon-o-eye'
                    )
                    ->color(fn (Category $record): string =>
                        $record->status === 'active' ? 'warning' : 'success'
                    )
                    ->requiresConfirmation()
                    ->modalHeading(fn (Category $record): string =>
                        $record->status === 'active' ? 'Ẩn danh mục?' : 'Hiện danh mục?'
                    )
                    ->modalDescription(fn (Category $record): string =>
                        $record->status === 'active'
                            ? 'Danh mục sẽ được chuyển sang trạng thái ngừng hoạt động.'
                            : 'Danh mục sẽ được chuyển sang trạng thái hoạt động.'
                    )
                    ->action(function (Category $record): void {
                        $record->update([
                            'status' => $record->status === 'active' ? 'inactive' : 'active',
                        ]);
                    })
                    ->successNotificationTitle('Đã cập nhật trạng thái danh mục'),
            ])
            ->defaultSort('category_id', 'asc');
    }
}
