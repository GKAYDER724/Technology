<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Product Management')
                    ->tabs([


                        Tab::make('Thông tin chung')
                            ->schema([

                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label('Danh mục sản phẩm')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Vui lòng chọn danh mục sản phẩm.',
                                    ])
                                    ->searchable()
                                    ->preload(),


                                TextInput::make('name')
                                    ->label('Tên sản phẩm')
                                    ->required()
                                    ->minLength(2)
                                    ->maxLength(200)
                                    ->validationMessages([
                                        'required' => 'Vui lòng nhập tên sản phẩm.',
                                        'minLength' => 'Tên sản phẩm tối thiểu 2 ký tự.',
                                        'maxLength' => 'Tên sản phẩm không vượt quá 200 ký tự.',
                                    ]),


                                TextInput::make('base_price')
                                    ->label('Giá gốc (VNĐ)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Vui lòng nhập giá gốc.',
                                        'min' => 'Giá sản phẩm không được âm.',
                                    ]),


                                TextInput::make('sale_price')
                                    ->label('Giá khuyến mãi (VNĐ)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->nullable()
                                    ->validationMessages([
                                        'min' => 'Giá khuyến mãi không được âm.',
                                    ]),


                                TextInput::make('stock')
                                    ->label('Tổng tồn kho')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->helperText(
                                        'Tự động tính từ tổng tồn kho biến thể.'
                                    ),


                                Select::make('status')
                                    ->label('Trạng thái')
                                    ->options([
                                        'active' => 'Đang bán',
                                        'inactive' => 'Ngừng bán',
                                    ])
                                    ->default('active')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Vui lòng chọn trạng thái.',
                                    ]),


                                RichEditor::make('description')
                                    ->label('Mô tả sản phẩm')
                                    ->columnSpanFull(),

                            ])
                            ->columns(2),



                        Tab::make('Thư viện hình ảnh')
                            ->schema([

                                Repeater::make('images')
                                    ->relationship('images')
                                    ->label('Danh sách hình ảnh')
                                    ->schema([

                                        FileUpload::make('image')
                                            ->label('Hình ảnh')
                                            ->image()
                                            ->directory('products'),

                                        Toggle::make('is_primary')
                                            ->label('Ảnh đại diện'),

                                    ])
                                    ->columns(2)
                                    ->columnSpanFull()
                                    ->addActionLabel('Thêm ảnh'),

                            ]),




                        Tab::make('Biến thể sản phẩm')
                            ->schema([

                                Repeater::make('variants')
                                    ->relationship('variants')
                                    ->label('Danh sách biến thể')
                                    ->schema([


                                        TextInput::make('variant_name')
                                            ->label('Tên biến thể')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Vui lòng nhập tên biến thể.',
                                            ]),


                                        TextInput::make('sku')
                                            ->label('SKU')
                                            ->required()
                                            ->unique()
                                            ->validationMessages([
                                                'required' => 'Vui lòng nhập mã SKU.',
                                                'unique' => 'Mã SKU đã tồn tại.',
                                            ]),


                                        TextInput::make('price')
                                            ->label('Giá biến thể')
                                            ->numeric()
                                            ->minValue(0)
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Vui lòng nhập giá biến thể.',
                                                'min' => 'Giá không được âm.',
                                            ]),


                                        TextInput::make('stock')
                                            ->label('Số lượng tồn')
                                            ->numeric()
                                            ->minValue(0)
                                            ->default(0)
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Vui lòng nhập số lượng tồn.',
                                                'min' => 'Số lượng không được âm.',
                                            ]),


                                        Select::make('status')
                                            ->label('Trạng thái')
                                            ->options([
                                                'active'=>'Đang bán',
                                                'inactive'=>'Ngừng bán',
                                            ])
                                            ->default('active')
                                            ->required(),

                                    ])
                                    ->columns(3)
                                    ->columnSpanFull()
                                    ->addActionLabel('Thêm biến thể'),

                            ]),


                    ])
                    ->columnSpanFull(),

            ]);
    }
}