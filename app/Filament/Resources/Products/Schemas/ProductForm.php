<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use App\Models\Product;
use App\Support\CloudinaryImage;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(12)
                ->schema([

                    // CỘT TRÁI
                    Grid::make(1)
                        ->schema([
                            Section::make('Thông tin sản phẩm')
                                ->description('Thông tin cơ bản của sản phẩm.')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Tên sản phẩm')
                                        ->placeholder('Nhập tên sản phẩm')
                                        ->required()
                                        ->maxLength(200),

                                    Grid::make(2)
                                        ->schema([
                                            Select::make('category_id')
                                                ->label('Danh mục')
                                                ->options(
                                                    Category::query()
                                                        ->orderBy('name')
                                                        ->pluck('name', 'category_id')
                                                        ->toArray()
                                                )
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->native(false),

                                            Select::make('status')
                                                ->label('Trạng thái')
                                                ->options([
                                                    'active' => 'Đang kinh doanh',
                                                    'inactive' => 'Ngừng kinh doanh',
                                                    'hidden' => 'Đang ẩn',
                                                ])
                                                ->default('active')
                                                ->required()
                                                ->native(false),
                                        ]),

                                    RichEditor::make('description')
                                        ->label('Mô tả sản phẩm')
                                        ->placeholder('Nhập mô tả chi tiết sản phẩm...')
                                        ->toolbarButtons([
                                            'bold',
                                            'italic',
                                            'underline',
                                            'strike',
                                            'bulletList',
                                            'orderedList',
                                            'h2',
                                            'h3',
                                            'blockquote',
                                            'link',
                                            'undo',
                                            'redo',
                                        ])
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Thư viện hình ảnh')
                                ->description('Quản lý hình ảnh chung của sản phẩm.')
                                ->schema([
                                    Repeater::make('images')
                                        ->label('Hình ảnh sản phẩm')
                                        ->relationship('images')
                                        ->defaultItems(0)
                                        ->schema([
                                            FileUpload::make('image')
                                                ->label('Hình ảnh')
                                                ->image()
                                                ->disk('cloudinary')
                                                ->fetchFileInformation(false)
                                                ->required()
                                                ->maxSize(5120)
                                                ->imageEditor()
                                                ->saveUploadedFileUsing(
                                                    function (TemporaryUploadedFile $file): ?string {
                                                        $publicId = 'products/gallery/' . Str::uuid();

                                                        $uploaded = Storage::disk('cloudinary')->put(
                                                            $publicId,
                                                            $file->get()
                                                        );

                                                        if (! $uploaded) {
                                                            throw new \RuntimeException('Không thể tải ảnh lên Cloudinary.');
                                                        }

                                                        return Storage::disk('cloudinary')->url($publicId);
                                                    }
                                                )
                                                ->getUploadedFileUsing(
                                                    function (string $file): array {
                                                        $url = Str::startsWith($file, ['http://', 'https://'])
                                                            ? $file
                                                            : Storage::disk('public')->url($file);

                                                        return [
                                                            'name' => basename(parse_url($file, PHP_URL_PATH) ?: $file),
                                                            'size' => 0,
                                                            'type' => null,
                                                            'url' => $url,
                                                        ];
                                                    }
                                                )
                                                ->deleteUploadedFileUsing(
                                                    function (string $file): void {
                                                        CloudinaryImage::delete($file);
                                                    }
                                                ),

                                            Checkbox::make('is_primary')
                                                ->label('Đặt làm ảnh đại diện')
                                                ->default(false),
                                        ])
                                        ->columns(2)
                                        ->addActionLabel('Thêm hình ảnh')
                                        ->reorderableWithButtons(),
                                ]),
                        ])
                        ->columnSpan(7),

                    // CỘT PHẢI
                    Grid::make(1)
                        ->schema([
                            Section::make('Cấu hình sản phẩm')
                                ->description('Thiết lập giá bán và tồn kho.')
                                ->schema([
                                    Toggle::make('has_variants')
                                        ->label('Sản phẩm có biến thể')
                                        ->helperText('Ví dụ: laptop có nhiều lựa chọn RAM hoặc SSD.')
                                        ->default(false)
                                        ->live()
                                        ->disabled(fn(string $operation): bool => $operation === 'edit')
                                        ->afterStateHydrated(
                                            function (Toggle $component, ?Product $record): void {
                                                $component->state(
                                                    $record?->variants()->exists() ?? false
                                                );
                                            }
                                        ),

                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('base_price')
                                                ->label('Giá gốc')
                                                ->numeric()
                                                ->minValue(0.01)
                                                ->prefix('₫')
                                                ->required(fn(Get $get): bool => ! $get('has_variants'))
                                                ->visible(fn(Get $get): bool => ! $get('has_variants')),

                                            TextInput::make('sale_price')
                                                ->label('Giá khuyến mãi')
                                                ->numeric()
                                                ->minValue(0.01)
                                                ->prefix('₫')
                                                ->nullable()
                                                ->visible(fn(Get $get): bool => ! $get('has_variants')),

                                            TextInput::make('stock')
                                                ->label('Số lượng tồn kho')
                                                ->numeric()
                                                ->integer()
                                                ->minValue(0)
                                                ->required(fn(Get $get): bool => ! $get('has_variants'))
                                                ->visible(fn(Get $get): bool => ! $get('has_variants'))
                                                ->columnSpanFull(),
                                        ]),
                                ]),

                            Section::make('Danh sách biến thể')
                                ->description('Mỗi biến thể có SKU, giá và tồn kho riêng.')
                                ->schema([
                                    Repeater::make('variants')
                                        ->label('Các biến thể')
                                        ->relationship('variants')
                                        ->schema([
                                            TextInput::make('variant_name')
                                                ->label('Tên biến thể')
                                                ->placeholder('Ví dụ: RAM 16GB')
                                                ->required()
                                                ->maxLength(150),

                                            TextInput::make('sku')
                                                ->label('Mã SKU')
                                                ->required()
                                                ->maxLength(100)
                                                ->unique(ignoreRecord: true),

                                            TextInput::make('price')
                                                ->label('Giá gốc')
                                                ->numeric()
                                                ->minValue(0.01)
                                                ->prefix('₫')
                                                ->required(),

                                            TextInput::make('sale_price')
                                                ->label('Giá khuyến mãi')
                                                ->numeric()
                                                ->minValue(0.01)
                                                ->prefix('₫')
                                                ->nullable(),

                                            TextInput::make('stock')
                                                ->label('Tồn kho')
                                                ->numeric()
                                                ->integer()
                                                ->minValue(0)
                                                ->default(0)
                                                ->required(),

                                            Select::make('status')
                                                ->label('Trạng thái')
                                                ->options([
                                                    'active' => 'Đang kinh doanh',
                                                    'inactive' => 'Ngừng kinh doanh',
                                                ])
                                                ->default('active')
                                                ->required()
                                                ->native(false),

                                            FileUpload::make('image')
                                                ->label('Ảnh đại diện biến thể')
                                                ->image()
                                                ->disk('cloudinary')
                                                ->fetchFileInformation(false)
                                                ->maxSize(5120)
                                                ->imageEditor()
                                                ->saveUploadedFileUsing(
                                                    function (TemporaryUploadedFile $file): ?string {
                                                        $publicId = 'products/variants/' . Str::uuid();

                                                        $uploaded = Storage::disk('cloudinary')->put(
                                                            $publicId,
                                                            $file->get()
                                                        );

                                                        if (! $uploaded) {
                                                            throw new \RuntimeException('Không thể tải ảnh lên Cloudinary.');
                                                        }

                                                        return Storage::disk('cloudinary')->url($publicId);
                                                    }
                                                )
                                                ->getUploadedFileUsing(
                                                    function (string $file): array {
                                                        $url = Str::startsWith($file, ['http://', 'https://'])
                                                            ? $file
                                                            : Storage::disk('public')->url($file);

                                                        return [
                                                            'name' => basename(parse_url($file, PHP_URL_PATH) ?: $file),
                                                            'size' => 0,
                                                            'type' => null,
                                                            'url' => $url,
                                                        ];
                                                    }
                                                )
                                                ->deleteUploadedFileUsing(
                                                    function (string $file): void {
                                                        CloudinaryImage::delete($file);
                                                    }
                                                )
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(2)
                                        ->minItems(1)
                                        ->addActionLabel('Thêm biến thể')
                                        ->reorderableWithButtons()
                                        ->visible(fn(Get $get): bool => (bool) $get('has_variants')),
                                ])
                                ->visible(fn(Get $get): bool => (bool) $get('has_variants')),
                        ])
                        ->columnSpan(5),
                ])
                ->columnSpanFull(),
        ]);
    }
}
