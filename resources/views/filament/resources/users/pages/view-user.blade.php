
<x-filament-panels::page>
    @php
        $user = $this->record;

        $roleName = \Illuminate\Support\Facades\DB::table('roles')
            ->where('role_id', $user->role_id)
            ->value('name') ?? 'Không xác định';

        $accountFields = [
            'Mã người dùng' => $user->user_id,
            'Họ và tên' => $user->fullname,
            'Email' => $user->email,
            'Vai trò' => $roleName,
            'Trạng thái' => match ($user->status) {
                'active' => 'Hoạt động',
                'inactive' => 'Ngừng hoạt động',
                default => $user->status,
            },
        ];

        $personalFields = [
            'Số điện thoại' => $user->phone ?: 'Chưa cập nhật',
            'Ngày sinh' => $user->date_of_birth
                ? \Illuminate\Support\Carbon::parse($user->date_of_birth)->format('d/m/Y')
                : 'Chưa cập nhật',
            'Giới tính' => match ($user->gender) {
                'male' => 'Nam',
                'female' => 'Nữ',
                'other' => 'Khác',
                default => 'Chưa cập nhật',
            },
        ];

        $addressFields = [
            'Địa chỉ' => $user->address ?: 'Chưa cập nhật',
            'Tỉnh / Thành phố' => $user->province_city ?: 'Chưa cập nhật',
        ];
    @endphp

    <style>
        .user-view {
            width: 100%;
            max-width: none;
            margin: 0;
            color: #111827;
        }

        .user-view .info-card {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 22px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.035);
        }

        .user-view .info-heading {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }

        .user-view .info-description {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 22px;
        }

        .user-view .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 24px;
            width: 100%;
        }

        .user-view .info-field {
            min-width: 0;
            width: 100%;
            max-width: none;
        }

        .user-view .info-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .user-view .info-input {
            display: block;
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            outline: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            cursor: default;
        }

        .user-view .info-input:focus {
            border-color: #d1d5db;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            .user-view .info-grid {
                grid-template-columns: 1fr;
            }

            .user-view .info-card {
                padding: 18px;
            }
        }
    </style>

    <div class="user-view">

        {{-- THÔNG TIN TÀI KHOẢN --}}
        <section class="info-card">
            <h2 class="info-heading">Thông tin tài khoản</h2>
            <p class="info-description">
                Thông tin đăng nhập và quyền truy cập hệ thống
            </p>

            <div class="info-grid">
                @foreach ($accountFields as $label => $value)
                    <div class="info-field">
                        <label class="info-label">{{ $label }}</label>
                        <input
                            class="info-input"
                            type="text"
                            value="{{ $value }}"
                            readonly
                        >
                    </div>
                @endforeach
            </div>
        </section>

        {{-- THÔNG TIN CÁ NHÂN --}}
        <section class="info-card">
            <h2 class="info-heading">Thông tin cá nhân</h2>
            <p class="info-description">
                Thông tin liên hệ và cá nhân của người dùng
            </p>

            <div class="info-grid">
                @foreach ($personalFields as $label => $value)
                    <div class="info-field">
                        <label class="info-label">{{ $label }}</label>
                        <input
                            class="info-input"
                            type="text"
                            value="{{ $value }}"
                            readonly
                        >
                    </div>
                @endforeach
            </div>
        </section>

        {{-- THÔNG TIN ĐỊA CHỈ --}}
        <section class="info-card">
            <h2 class="info-heading">Thông tin địa chỉ</h2>
            <p class="info-description">
                Địa chỉ hiện tại của người dùng
            </p>

            <div class="info-grid">
                @foreach ($addressFields as $label => $value)
                    <div class="info-field">
                        <label class="info-label">{{ $label }}</label>
                        <input
                            class="info-input"
                            type="text"
                            value="{{ $value }}"
                            readonly
                        >
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</x-filament-panels::page>
