<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(120)
                    ->unique(ignoreRecord: true)
                    ->label('Tên danh mục')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required(false)
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Slug (Đường dẫn)'),

                Select::make('parent_id')
                    ->label('Danh mục cha')
                    ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('-- Chọn danh mục gốc (nếu có) --'),

                Select::make('status')
                    ->options([
                        'active' => 'Đang hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                    ])
                    ->default('active')
                    ->required()
                    ->label('Trạng thái'),
            ]);
    }
}