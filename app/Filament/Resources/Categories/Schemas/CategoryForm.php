<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Tên danh mục')
                    ->rule('required')
                    ->minLength(2)
                    ->maxLength(120)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Vui lòng nhập tên danh mục.',
                        'minLength' => 'Tên danh mục phải có ít nhất 2 ký tự.',
                        'maxLength' => 'Tên danh mục không được vượt quá 120 ký tự.',
                        'unique' => 'Tên danh mục đã tồn tại.',
                    ]),


                Select::make('parent_id')
                    ->label('Danh mục cha')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name'
                    )
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('-- Chọn danh mục gốc (nếu có) --'),


                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Đang hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                    ])
                    ->default('active')
                    ->rule('required')
                    ->validationMessages([
                        'required' => 'Vui lòng chọn trạng thái.',
                    ]),
            ]);
    }
}