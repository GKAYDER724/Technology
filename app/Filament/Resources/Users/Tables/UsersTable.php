<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('Mã người dùng')
                    ->sortable(),

                TextColumn::make('fullname')
                    ->label('Họ và tên')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('role_id')
                    ->label('Mã vai trò')
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Số điện thoại'),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('deleted_at')
                    ->label('Ngày xóa')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—'),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label('Tài khoản đã xóa'),

                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Hoạt động',
                        'inactive' => 'Ngừng hoạt động',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),

                Action::make('lock')
                    ->label('Khóa tài khoản')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool =>
                        ! $record->trashed() && $record->status === 'active'
                    )
                    ->action(fn (User $record) =>
                        $record->update(['status' => 'inactive'])
                    )
                    ->successNotificationTitle('Đã khóa tài khoản'),

                Action::make('unlock')
                    ->label('Mở khóa tài khoản')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool =>
                        ! $record->trashed() && $record->status === 'inactive'
                    )
                    ->action(fn (User $record) =>
                        $record->update(['status' => 'active'])
                    )
                    ->successNotificationTitle('Đã mở khóa tài khoản'),

                DeleteAction::make()
                    ->label('Xóa'),

                RestoreAction::make()
                    ->label('Khôi phục'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa tài khoản đã chọn'),

                    RestoreBulkAction::make()
                        ->label('Khôi phục tài khoản đã chọn'),
                ]),
            ]);
    }
}
