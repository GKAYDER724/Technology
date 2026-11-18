<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               TextInput::make('name')
    ->label('Tên danh mục')
    ->required()
    ->maxLength(120)
    ->trim()
    ->regex('/^(?=.*[\p{L}\p{N}])[\p{L}\p{N}\s&().,\-]+$/u')
    ->unique(ignoreRecord: true)
    ->validationMessages([
        'required' => 'Vui lòng nhập tên danh mục.',
        'max' => 'Tên danh mục không được vượt quá 120 ký tự.',
        'unique' => 'Tên danh mục này đã tồn tại.',
        'regex' => 'Tên danh mục chứa ký tự không hợp lệ.',
    ]),

                Select::make('parent_id')
                    ->label('Danh mục cha')
                    ->placeholder('Không có (danh mục gốc)')
                    ->options(fn (?Category $record): array =>
                        static::getParentOptions($record)
                    )
                    ->searchable()
                    ->native(false)
                    ->nullable()
                    ->helperText('Để trống nếu đây là danh mục cấp cao nhất.')
                    ->rules([
                        function (?Category $record): \Closure {
                            return function (
                                string $attribute,
                                mixed $value,
                                \Closure $fail
                            ) use ($record): void {
                                if (blank($value)) {
                                    return;
                                }

                                if (! is_numeric($value) || (int) $value <= 0) {
                                    $fail('Danh mục cha không hợp lệ.');

                                    return;
                                }

                                $parent = Category::query()->find((int) $value);

                                if (! $parent) {
                                    $fail('Danh mục cha không tồn tại.');

                                    return;
                                }

                                if (! $record) {
                                    return;
                                }

                                if ((int) $value === (int) $record->getKey()) {
                                    $fail('Danh mục không thể là cha của chính nó.');

                                    return;
                                }

                                if (static::isDescendantOf($parent, $record)) {
                                    $fail('Không thể chọn danh mục con hoặc hậu duệ làm danh mục cha.');
                                }
                            };
                        },
                    ]),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                    ])
                    ->default('active')
                    ->required()
                    ->in(['active', 'inactive'])
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Vui lòng chọn trạng thái.',
                        'in' => 'Trạng thái không hợp lệ.',
                    ]),
            ]);
    }

    /**
     * Lấy danh sách danh mục có thể chọn làm cha.
     */
    protected static function getParentOptions(?Category $record): array
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        if (! $record) {
            return $categories->pluck('name', 'category_id')->all();
        }

        $excludedIds = collect([$record->getKey()]);

        $collectDescendants = function (Category $category) use (&$collectDescendants, $excludedIds): void {
            $children = Category::query()
                ->where('parent_id', $category->getKey())
                ->get();

            foreach ($children as $child) {
                if ($excludedIds->contains($child->getKey())) {
                    continue;
                }

                $excludedIds->push($child->getKey());

                $collectDescendants($child);
            }
        };

        $collectDescendants($record);

        return $categories
            ->reject(fn (Category $category): bool =>
                $excludedIds->contains($category->getKey())
            )
            ->mapWithKeys(fn (Category $category): array => [
                $category->getKey() => $category->parent_id
                    ? '— ' . $category->name
                    : $category->name,
            ])
            ->all();
    }

    /**
     * Kiểm tra một danh mục có nằm bên dưới danh mục gốc hay không.
     */
    protected static function isDescendantOf(
        Category $category,
        Category $ancestor
    ): bool {
        $visited = [];

        while ($category->parent_id !== null) {
            $parentId = (int) $category->parent_id;

            if ($parentId === (int) $ancestor->getKey()) {
                return true;
            }

            // Phòng trường hợp dữ liệu cũ đã có vòng lặp.
            if (in_array($parentId, $visited, true)) {
                return false;
            }

            $visited[] = $parentId;

            $category = Category::query()->find($parentId);

            if (! $category) {
                return false;
            }
        }

        return false;
    }
}
