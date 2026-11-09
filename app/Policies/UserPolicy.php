<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Xem danh sách tài khoản: chỉ Admin
    public function viewAny(User $actor): bool
    {
        return (int) $actor->role_id === 1;
    }

    // Xem tài khoản: Admin hoặc chính chủ
    public function view(User $actor, User $target): bool
    {
        return (int) $actor->role_id === 1
            || (int) $actor->user_id === (int) $target->user_id;
    }

    // Tạo tài khoản qua chức năng quản lý: chỉ Admin
    public function create(User $actor): bool
    {
        return (int) $actor->role_id === 1;
    }

    // Cập nhật tài khoản: Admin hoặc chính chủ
    public function update(User $actor, User $target): bool
    {
        return (int) $actor->role_id === 1
            || (int) $actor->user_id === (int) $target->user_id;
    }

    // Xóa tài khoản: Admin, không được xóa chính mình
    public function delete(User $actor, User $target): bool
    {
        return (int) $actor->role_id === 1
            && (int) $actor->user_id !== (int) $target->user_id;
    }
}

