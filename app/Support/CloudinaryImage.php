<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CloudinaryImage
{
    public static function delete(?string $file): void
    {
        if (blank($file)) {
            return;
        }

        $url = parse_url($file);

        // Chỉ chấp nhận URL HTTPS từ Cloudinary.
        if (
            ($url['scheme'] ?? null) !== 'https' ||
            ($url['host'] ?? null) !== 'res.cloudinary.com'
        ) {
            return;
        }

        $cloudName = config('filesystems.disks.cloudinary.cloud_name');

        if (blank($cloudName)) {
            return;
        }

        $path = $url['path'] ?? '';
        $prefix = "/{$cloudName}/image/upload/";

        if (! Str::startsWith($path, $prefix)) {
            return;
        }

        $publicId = Str::after($path, $prefix);

        // Bỏ version v123456789/ nếu có.
        $publicId = preg_replace('/^v\d+\//', '', $publicId);

        // Chỉ xóa ảnh mới có UUID trong hai thư mục do hệ thống tạo.
        $pattern = '~^products/(gallery|variants)/[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$~i';

        if (! preg_match($pattern, $publicId)) {
            return;
        }

        Storage::disk('cloudinary')->delete($publicId);
    }
}
