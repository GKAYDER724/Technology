<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // THÔNG TIN TÀI KHOẢN
                Section::make('Thông tin tài khoản')
                    ->description('Thông tin đăng nhập và quyền truy cập hệ thống')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextEntry::make('user_id')
                            ->label('Mã người dùng')
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),

                        TextEntry::make('fullname')
                            ->label('Họ và tên')
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),

                        TextEntry::make('email')
                            ->label('Email')
                            ->copyable()
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),

                        TextEntry::make('role_id')
                            ->label('Vai trò')
                            ->formatStateUsing(
                                fn ($state) => DB::table('roles')
                                    ->where('role_id', $state)
                                    ->value('name') ?? 'Không xác định'
                            )
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),

                        TextEntry::make('status')
                            ->label('Trạng thái')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'active' => 'Hoạt động',
                                'inactive' => 'Ngừng hoạt động',
                                default => $state,
                            })
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'active' => 'success',
                                'inactive' => 'danger',
                                default => 'gray',
                            })
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                // THÔNG TIN CÁ NHÂN
                Section::make('Thông tin cá nhân')
                    ->description('Thông tin liên hệ và cá nhân của người dùng')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextEntry::make('phone')
                            ->label('Số điện thoại')
                            ->placeholder('Chưa cập nhật')
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),

                        TextEntry::make('date_of_birth')
                            ->label('Ngày sinh')
                            ->date('d/m/Y')
                            ->placeholder('Chưa cập nhật')
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),

                        TextEntry::make('gender')
                            ->label('Giới tính')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'male' => 'Nam',
                                'female' => 'Nữ',
                                'other' => 'Khác',
                                default => 'Chưa cập nhật',
                            })
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                // THÔNG TIN ĐỊA CHỈ
                Section::make('Thông tin địa chỉ')
                    ->description('Địa chỉ hiện tại của người dùng')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        TextEntry::make('address')
                            ->label('Địa chỉ')
                            ->placeholder('Chưa cập nhật')
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ])
                            ->columnSpanFull(),

                        TextEntry::make('province_city')
                            ->label('Tỉnh / Thành phố')
                            ->placeholder('Chưa cập nhật')
                            ->extraEntryWrapperAttributes([
                                'class' => 'rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3',
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}
