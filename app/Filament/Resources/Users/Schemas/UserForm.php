<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role_id')
                    ->label('Vai trò')
                    ->options(
                        \Illuminate\Support\Facades\DB::table('roles')
                            ->pluck('name', 'role_id')
                            ->toArray()
                    )
                    ->required()
                    ->native(false),

                TextInput::make('fullname')
                    ->label('Họ và tên')
                    ->required()
                    ->maxLength(120),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(190)
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Mật khẩu')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Số điện thoại')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('address')
                    ->label('Địa chỉ')
                    ->maxLength(500),

                DatePicker::make('date_of_birth')
                    ->label('Ngày sinh')
                    ->native(false),

                Select::make('gender')
                    ->label('Giới tính')
                    ->options([
                        'male' => 'Nam',
                        'female' => 'Nữ',
                        'other' => 'Khác',
                    ])
                    ->native(false),

                TextInput::make('province_city')
                    ->label('Tỉnh / Thành phố')
                    ->maxLength(120),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                    ])
                    ->default('active')
                    ->required()
                    ->native(false),
            ]);
    }
}
