<?php

namespace App\Data;

class MockData
{
    public static function getCategories(): array
    {
        return [
            ['id' => 'laptop', 'name' => 'Laptop & Máy tính', 'icon' => 'bi-laptop', 'count' => 142, 'slug' => 'laptop'],
            ['id' => 'phone', 'name' => 'Điện thoại & Tablet', 'icon' => 'bi-phone', 'count' => 285, 'slug' => 'phone'],
            ['id' => 'audio', 'name' => 'Tai nghe & Âm thanh', 'icon' => 'bi-headphones', 'count' => 96, 'slug' => 'audio'],
            ['id' => 'monitor', 'name' => 'Màn hình & PC Gaming', 'icon' => 'bi-display', 'count' => 64, 'slug' => 'monitor'],
            ['id' => 'smartwatch', 'name' => 'Đồng hồ thông minh', 'icon' => 'bi-smartwatch', 'count' => 58, 'slug' => 'smartwatch'],
            ['id' => 'accessory', 'name' => 'Phụ kiện công nghệ', 'icon' => 'bi-keyboard', 'count' => 310, 'slug' => 'accessory'],
            ['id' => 'smart-home', 'name' => 'Thiết bị thông minh', 'icon' => 'bi-router', 'count' => 45, 'slug' => 'smart-home'],
        ];
    }

    public static function getProducts(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Laptop Asus ROG Zephyrus G16 (2025) OLED',
                'sku' => 'ASUS-ROG-G16-GU605',
                'brand' => 'ASUS',
                'category' => 'laptop',
                'price' => 54990000,
                'original_price' => 62990000,
                'discount' => 13,
                'rating' => 4.9,
                'reviews_count' => 128,
                'sold' => 84,
                'stock' => 16,
                'is_featured' => true,
                'is_hot' => true,
                'badge' => 'Flash Sale',
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80',
                ],
                'specs_summary' => 'Intel Core Ultra 9 · 32GB RAM · 1TB SSD · RTX 4070 · Màn 2.5K OLED 240Hz',
                'specs' => [
                    'CPU' => 'Intel Core Ultra 9 185H (16 nhân, 22 luồng, up to 5.1GHz)',
                    'RAM' => '32GB LPDDR5X 7467MHz Dual Channel',
                    'Ổ cứng' => '1TB PCIe 4.0 NVMe M.2 SSD siêu tốc',
                    'Card đồ họa' => 'NVIDIA GeForce RTX 4070 8GB GDDR6',
                    'Màn hình' => '16.0" 2.5K (2560x1600) OLED 240Hz 0.2ms 100% DCI-P3 G-Sync',
                    'Pin' => '90WHrs 4-cell Li-ion, hỗ trợ sạc nhanh 100W Type-C',
                    'Trọng lượng' => '1.85 kg siêu nhẹ khung nhôm CNC',
                    'Hệ điều hành' => 'Windows 11 Home bản quyền'
                ],
                'variants_config' => [
                    'Ultra 9 / 32GB / 1TB / RTX 4070',
                    'Ultra 7 / 16GB / 512GB / RTX 4060'
                ],
                'variants_color' => ['Xám Eclipse Gray', 'Trắng Platinum White'],
                'gifts' => [
                    'Balo Asus ROG Gaming cao cấp chống nước',
                    'Chuột gaming không dây ROG Strix Impact III',
                    'Gói bảo hành vàng 24 tháng tận nơi'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Apple iPhone 16 Pro Max 256GB Titan Tự Nhiên',
                'sku' => 'IPHONE-16PM-256',
                'brand' => 'Apple',
                'category' => 'phone',
                'price' => 34490000,
                'original_price' => 36990000,
                'discount' => 7,
                'rating' => 5.0,
                'reviews_count' => 342,
                'sold' => 210,
                'stock' => 25,
                'is_featured' => true,
                'is_hot' => true,
                'badge' => 'Bán chạy nhất',
                'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?auto=format&fit=crop&w=800&q=80',
                ],
                'specs_summary' => 'Chip Apple A18 Pro · 256GB · Màn 6.9" Super Retina XDR OLED 120Hz ProMotion',
                'specs' => [
                    'Màn hình' => '6.9 inch Super Retina XDR OLED ProMotion 120Hz',
                    'Chipset' => 'Apple A18 Pro 3nm thế hệ mới có Neural Engine 16 lõi',
                    'Bộ nhớ trong' => '256GB NVMe',
                    'Camera chính' => '48MP Fusion + 48MP Ultra Wide + 12MP Tele 5x Zoom quang',
                    'Pin & Sạc' => 'Xem video liên tục 33 giờ, hỗ trợ sạc MagSafe 25W',
                    'Chất liệu' => 'Khung Titan chuẩn hàng không vũ trụ cao cấp',
                    'Kháng nước' => 'Chuẩn IP68 (độ sâu 6 mét trong 30 phút)'
                ],
                'variants_config' => ['256GB', '512GB', '1TB'],
                'variants_color' => ['Titan Sa Mạc', 'Titan Tự Nhiên', 'Titan Trắng', 'Titan Đen'],
                'gifts' => [
                    'Củ sạc nhanh 30W USB-C chính hãng Apple',
                    'Ốp lưng từ tính MagSafe cao cấp'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Tai nghe Sony WH-1000XM5 Chống Ồn Chủ Động',
                'sku' => 'SONY-WH-1000XM5-BLK',
                'brand' => 'Sony',
                'category' => 'audio',
                'price' => 7490000,
                'original_price' => 8990000,
                'discount' => 17,
                'rating' => 4.8,
                'reviews_count' => 95,
                'sold' => 140,
                'stock' => 18,
                'is_featured' => true,
                'is_hot' => false,
                'badge' => 'Ưa chuộng',
                'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80'
                ],
                'specs_summary' => 'Bộ xử lý V1 + QN1 · 8 Micro chống ồn · Pin 30 giờ · Bluetooth 5.2 LDAC Hi-Res Audio',
                'specs' => [
                    'Chống ồn' => 'Công nghệ Auto NC Optimizer với 8 micro và 2 bộ xử lý',
                    'Âm thanh' => 'Driver 30mm màng sợi carbon, hỗ trợ Hi-Res Audio Wireless LDAC',
                    'Thời lượng pin' => '30 giờ (bật NC), sạc 3 phút dùng 3 giờ',
                    'Tính năng' => 'Speak-to-Chat, điều khiển cảm ứng thông minh',
                    'Trọng lượng' => '250g đệm tai da êm ái Soft Fit'
                ],
                'variants_config' => ['Bản Tiêu Chuẩn'],
                'variants_color' => ['Đen Nhám Midnight', 'Bạc Platinum Silver'],
                'gifts' => ['Hộp đựng da du lịch cao cấp', 'Cáp âm thanh 3.5mm mạ vàng']
            ],
            [
                'id' => 4,
                'name' => 'Màn hình Gaming Dell Alienware AW3423DWF 34" QD-OLED 165Hz',
                'sku' => 'DELL-AW3423DWF',
                'brand' => 'Dell',
                'category' => 'monitor',
                'price' => 26990000,
                'original_price' => 31990000,
                'discount' => 15,
                'rating' => 4.9,
                'reviews_count' => 64,
                'sold' => 42,
                'stock' => 8,
                'is_featured' => true,
                'is_hot' => true,
                'badge' => 'Đỉnh cao OLED',
                'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
                ],
                'specs_summary' => '34 inch Cong 1800R · QD-OLED · WQHD 3440x1440 · 165Hz · 0.1ms · 99.3% DCI-P3',
                'specs' => [
                    'Tấm nền' => 'Quantum Dot OLED (QD-OLED) cong 1800R',
                    'Độ phân giải' => 'WQHD 3440 x 1440 tỉ lệ 21:9',
                    'Tần số quét' => '165Hz, thời gian đáp ứng 0.1ms Gray-to-Gray',
                    'Màu sắc' => '99.3% DCI-P3, HDR TrueBlack 400, độ sáng đỉnh 1000 nits',
                    'Cổng kết nối' => '2x DP 1.4, 1x HDMI 2.0, 4x USB 3.2'
                ],
                'variants_config' => ['34 inch Cong QD-OLED'],
                'variants_color' => ['Màu Đen Ánh Bạc Alienware'],
                'gifts' => ['Cáp DisplayPort 1.4 bọc dù', 'Gói bảo hành chống burn-in 3 năm']
            ],
            [
                'id' => 5,
                'name' => 'Bàn phím cơ không dây Logitech MX Mechanical Mini Tactile Quiet',
                'sku' => 'LOGI-MX-MECH-MINI',
                'brand' => 'Logitech',
                'category' => 'accessory',
                'price' => 3190000,
                'original_price' => 3690000,
                'discount' => 14,
                'rating' => 4.7,
                'reviews_count' => 82,
                'sold' => 195,
                'stock' => 35,
                'is_featured' => false,
                'is_hot' => false,
                'badge' => 'Công sở cao cấp',
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80'
                ],
                'specs_summary' => 'Switch Low-Profile Tactile · Đèn nền cảm biến tiệm cận · Pin 10 tháng · Kết nối 3 thiết bị',
                'specs' => [
                    'Switch' => 'Kailh Low Profile Tactile Quiet (gõ êm, cảm giác rõ)',
                    'Kết nối' => 'Bluetooth Low Energy & Đầu thu Logi Bolt USB',
                    'Pin' => 'Sạc USB-C, lên tới 15 ngày có đèn nền hoặc 10 tháng không đèn',
                    'Tính năng' => 'Easy-Switch chuyển đổi giữa 3 thiết bị Windows, macOS, iPadOS'
                ],
                'variants_config' => ['Tactile Quiet', 'Linear', 'Clicky'],
                'variants_color' => ['Graphite Xám Đen', 'Pale Grey Trắng Bạc'],
                'gifts' => ['Đầu thu Logi Bolt USB Receiver']
            ],
            [
                'id' => 6,
                'name' => 'Samsung Galaxy Tab S10 Ultra 5G 256GB Kèm Bút S-Pen',
                'sku' => 'SS-TABS10U-5G',
                'brand' => 'Samsung',
                'category' => 'phone',
                'price' => 30990000,
                'original_price' => 33990000,
                'discount' => 9,
                'rating' => 4.8,
                'reviews_count' => 49,
                'sold' => 68,
                'stock' => 14,
                'is_featured' => true,
                'is_hot' => false,
                'badge' => 'Mới ra mắt',
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=800&q=80'
                ],
                'specs_summary' => 'Màn 14.6" Dynamic AMOLED 2X 120Hz chống chói · Dimensity 9300+ · Pin 11.200mAh',
                'specs' => [
                    'Màn hình' => '14.6" Dynamic AMOLED 2X 120Hz Anti-Reflection',
                    'Bộ nhớ' => '12GB RAM, 256GB ROM có khe thẻ nhớ micro SD 1.5TB',
                    'Bút cảm ứng' => 'S-Pen tặng kèm trong hộp, độ trễ 2.8ms',
                    'Pin' => '11,200 mAh hỗ trợ sạc siêu nhanh 45W'
                ],
                'variants_config' => ['256GB 5G', '512GB 5G'],
                'variants_color' => ['Xám Moonstone', 'Bạc Platinum'],
                'gifts' => ['Bao da kiêm bàn phím chính hãng', 'Bút S-Pen độ nhạy cao']
            ]
        ];
    }

    public static function getOrders(): array
    {
        return [
            [
                'id' => 'DH-20261010-891',
                'created_at' => '10/10/2026 09:15',
                'status' => 'pending',
                'status_label' => 'Chờ xác nhận',
                'status_color' => 'warning',
                'total_amount' => 54990000,
                'payment_method' => 'Thanh toán khi nhận hàng (COD)',
                'payment_status' => 'Chưa thanh toán',
                'shipping_method' => 'Giao hàng hỏa tốc 2H',
                'shipping_fee' => 0,
                'discount_amount' => 500000,
                'can_cancel' => true,
                'receiver' => [
                    'name' => 'Nguyễn Văn Minh',
                    'phone' => '0988 123 456',
                    'address' => 'Số 18, Ngõ 45 Đường Hoàng Quốc Việt, Phường Nghĩa Đô, Quận Cầu Giấy, Hà Nội',
                    'note' => 'Giao trong giờ hành chính, gọi trước 15 phút'
                ],
                'items' => [
                    [
                        'product_id' => 1,
                        'name' => 'Laptop Asus ROG Zephyrus G16 (2025) OLED',
                        'variant' => 'Ultra 9 / 32GB / 1TB / RTX 4070 · Xám Eclipse Gray',
                        'price' => 54990000,
                        'quantity' => 1,
                        'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                'timeline' => [
                    ['title' => 'Đã đặt hàng', 'time' => '10/10/2026 09:15', 'done' => true],
                    ['title' => 'Chờ xác nhận', 'time' => '10/10/2026 09:20', 'done' => true],
                    ['title' => 'Đang đóng gói', 'time' => 'Dự kiến hôm nay', 'done' => false],
                    ['title' => 'Đang giao hàng', 'time' => 'Dự kiến hôm nay', 'done' => false],
                    ['title' => 'Giao thành công', 'time' => 'Dự kiến 11/10/2026', 'done' => false],
                ]
            ],
            [
                'id' => 'DH-20261005-724',
                'created_at' => '05/10/2026 14:30',
                'status' => 'shipping',
                'status_label' => 'Đang giao hàng',
                'status_color' => 'info',
                'total_amount' => 7490000,
                'payment_method' => 'Chuyển khoản QR VietQR',
                'payment_status' => 'Đã thanh toán',
                'shipping_method' => 'Giao hàng tiêu chuẩn (VNPost)',
                'shipping_fee' => 0,
                'discount_amount' => 200000,
                'can_cancel' => false,
                'receiver' => [
                    'name' => 'Nguyễn Văn Minh',
                    'phone' => '0988 123 456',
                    'address' => 'Số 18, Ngõ 45 Đường Hoàng Quốc Việt, Phường Nghĩa Đô, Quận Cầu Giấy, Hà Nội',
                    'note' => ''
                ],
                'items' => [
                    [
                        'product_id' => 3,
                        'name' => 'Tai nghe Sony WH-1000XM5 Chống Ồn Chủ Động',
                        'variant' => 'Đen Nhám Midnight · Tiêu Chuẩn',
                        'price' => 7490000,
                        'quantity' => 1,
                        'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                'timeline' => [
                    ['title' => 'Đã đặt hàng', 'time' => '05/10/2026 14:30', 'done' => true],
                    ['title' => 'Xác nhận thanh toán', 'time' => '05/10/2026 14:35', 'done' => true],
                    ['title' => 'Đã xuất kho đóng gói', 'time' => '06/10/2026 08:45', 'done' => true],
                    ['title' => 'Đang vận chuyển (Hà Nội Hub)', 'time' => '07/10/2026 10:10', 'done' => true],
                    ['title' => 'Giao thành công', 'time' => 'Dự kiến hôm nay', 'done' => false],
                ]
            ],
            [
                'id' => 'DH-20260920-512',
                'created_at' => '20/09/2026 11:00',
                'status' => 'completed',
                'status_label' => 'Đã giao thành công',
                'status_color' => 'success',
                'total_amount' => 3190000,
                'payment_method' => 'Thẻ tín dụng Visa/MasterCard',
                'payment_status' => 'Đã thanh toán',
                'shipping_method' => 'Giao tiêu chuẩn',
                'shipping_fee' => 0,
                'discount_amount' => 0,
                'can_cancel' => false,
                'receiver' => [
                    'name' => 'Nguyễn Văn Minh',
                    'phone' => '0988 123 456',
                    'address' => 'Số 18, Ngõ 45 Đường Hoàng Quốc Việt, Phường Nghĩa Đô, Quận Cầu Giấy, Hà Nội',
                    'note' => ''
                ],
                'items' => [
                    [
                        'product_id' => 5,
                        'name' => 'Bàn phím cơ không dây Logitech MX Mechanical Mini',
                        'variant' => 'Switch Tactile Quiet · Màu Graphite',
                        'price' => 3190000,
                        'quantity' => 1,
                        'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                'timeline' => [
                    ['title' => 'Đã đặt hàng', 'time' => '20/09/2026 11:00', 'done' => true],
                    ['title' => 'Đã giao hàng thành công', 'time' => '22/09/2026 16:20', 'done' => true],
                ]
            ],
            [
                'id' => 'DH-20260815-309',
                'created_at' => '15/08/2026 19:40',
                'status' => 'cancelled',
                'status_label' => 'Đã hủy',
                'status_color' => 'secondary',
                'total_amount' => 34490000,
                'payment_method' => 'COD',
                'payment_status' => 'Đã hủy',
                'shipping_method' => 'Tiêu chuẩn',
                'shipping_fee' => 0,
                'discount_amount' => 0,
                'can_cancel' => false,
                'cancel_reason' => 'Khách hàng thay đổi nhu cầu đặt phiên bản 512GB',
                'receiver' => [
                    'name' => 'Nguyễn Văn Minh',
                    'phone' => '0988 123 456',
                    'address' => 'Số 18, Ngõ 45 Đường Hoàng Quốc Việt, Phường Nghĩa Đô, Quận Cầu Giấy, Hà Nội',
                    'note' => ''
                ],
                'items' => [
                    [
                        'product_id' => 2,
                        'name' => 'Apple iPhone 16 Pro Max 256GB Titan Tự Nhiên',
                        'variant' => 'Titan Tự Nhiên · 256GB',
                        'price' => 34490000,
                        'quantity' => 1,
                        'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=800&q=80'
                    ]
                ]
            ]
        ];
    }

    public static function getCart(): array
    {
        return [
            'items' => [
                [
                    'id' => 101,
                    'product_id' => 1,
                    'name' => 'Laptop Asus ROG Zephyrus G16 (2025) OLED',
                    'variant' => 'Ultra 9 / 32GB / 1TB / RTX 4070 · Xám Eclipse Gray',
                    'price' => 54990000,
                    'original_price' => 62990000,
                    'quantity' => 1,
                    'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80',
                    'stock' => 16,
                    'warranty' => 'Bảo hành chính hãng 24 tháng'
                ],
                [
                    'id' => 102,
                    'product_id' => 5,
                    'name' => 'Bàn phím cơ không dây Logitech MX Mechanical Mini',
                    'variant' => 'Switch Tactile Quiet · Màu Graphite',
                    'price' => 3190000,
                    'original_price' => 3690000,
                    'quantity' => 1,
                    'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                    'stock' => 35,
                    'warranty' => 'Bảo hành chính hãng 12 tháng'
                ]
            ],
            'coupon_code' => 'ELECTRO500K',
            'discount' => 500000,
            'shipping' => 0
        ];
    }

    public static function getUser(): array
    {
        return [
            'name' => 'Nguyễn Văn Minh',
            'username' => 'minh_tech26',
            'email' => 'minh.nguyen@example.com',
            'phone' => '0988 123 456',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
            'gender' => 'Nam',
            'birthday' => '1995-10-15',
            'member_tier' => 'Gold Member',
            'points' => 3240,
            'orders_count' => 8,
            'address' => 'Số 18, Ngõ 45 Đường Hoàng Quốc Việt, Phường Nghĩa Đô, Quận Cầu Giấy, Hà Nội',
            'city' => 'Hà Nội',
            'district' => 'Cầu Giấy',
            'ward' => 'Nghĩa Đô',
            'joined_date' => '15/03/2023',
            'is_email_verified' => true,
            'is_phone_verified' => true,
            'two_factor_enabled' => true
        ];
    }

    public static function getNotifications(): array
    {
        return [
            [
                'id' => 1,
                'type' => 'order',
                'title' => 'Đơn hàng #DH-20261010-891 đã được tiếp nhận',
                'content' => 'Đơn hàng mua Laptop Asus ROG Zephyrus G16 đang được bộ phận kho kiểm tra và chuẩn bị hàng.',
                'time' => '10 phút trước',
                'is_read' => false,
                'link' => '/orders/DH-20261010-891',
                'icon' => 'bi-box-seam',
                'badge' => 'Đơn hàng'
            ],
            [
                'id' => 2,
                'type' => 'promo',
                'title' => 'Voucher 500.000đ Flash Sale cuối tuần dành riêng cho bạn',
                'content' => 'Sử dụng mã TECHWEEKEND áp dụng cho toàn bộ thiết bị âm thanh và màn hình gaming trên 5 triệu.',
                'time' => '2 giờ trước',
                'is_read' => false,
                'link' => '/products',
                'icon' => 'bi-tag',
                'badge' => 'Khuyến mãi'
            ],
            [
                'id' => 3,
                'type' => 'order',
                'title' => 'Đơn hàng #DH-20261005-724 đang trên đường vận chuyển',
                'content' => 'Shipper Nguyễn Tuấn Anh (0902.xxx.xxx) đang giao tai nghe Sony WH-1000XM5 đến địa chỉ Cầu Giấy của bạn.',
                'time' => '1 ngày trước',
                'is_read' => true,
                'link' => '/orders/DH-20261005-724',
                'icon' => 'bi-truck',
                'badge' => 'Vận chuyển'
            ],
            [
                'id' => 4,
                'type' => 'system',
                'title' => 'Nâng cấp bảo mật tài khoản 2 lớp thành công',
                'content' => 'Xác thực OTP qua điện thoại cho tài khoản minh_tech26 đã được kích hoạt thành công.',
                'time' => '3 ngày trước',
                'is_read' => true,
                'link' => '/account/profile',
                'icon' => 'bi-shield-check',
                'badge' => 'Hệ thống'
            ],
            [
                'id' => 5,
                'type' => 'warranty',
                'title' => 'Kích hoạt bảo hành điện tử chính hãng',
                'content' => 'Bàn phím Logitech MX Mechanical Mini đã được kích hoạt bảo hành điện tử 12 tháng từ ngày 22/09/2026.',
                'time' => '2 tuần trước',
                'is_read' => true,
                'link' => '/orders/DH-20260920-512',
                'icon' => 'bi-patch-check',
                'badge' => 'Bảo hành'
            ]
        ];
    }

    public static function getReviews(): array
    {
        return [
            'pending' => [
                [
                    'order_id' => 'DH-20260920-512',
                    'product_id' => 5,
                    'name' => 'Bàn phím cơ không dây Logitech MX Mechanical Mini',
                    'variant' => 'Switch Tactile Quiet · Màu Graphite',
                    'bought_at' => '22/09/2026',
                    'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80'
                ]
            ],
            'submitted' => [
                [
                    'id' => 1,
                    'user_name' => 'Nguyễn Văn Minh',
                    'user_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                    'product_id' => 3,
                    'product_name' => 'Tai nghe Sony WH-1000XM5 Chống Ồn Chủ Động',
                    'rating' => 5,
                    'created_at' => '07/10/2026',
                    'comment' => 'Chống ồn siêu êm! Mình dùng đi máy bay và ngồi quán cà phê làm việc gần như triệt tiêu hết tiếng ồn xung quanh. Đệm tai êm, không bị bí tai sau 4-5 tiếng đeo liên tục. Giao hàng của shop rất nhanh, đóng gói 3 lớp xốp khí an tâm.',
                    'images' => [
                        'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=400&q=80'
                    ],
                    'likes' => 14,
                    'verified' => true,
                    'reply' => 'Cảm ơn anh Minh đã tin tưởng và đánh giá chi tiết cho ElectroStore! Chúc anh có những phút giây trải nghiệm âm thanh tuyệt vời cùng Sony WH-1000XM5 ạ!'
                ],
                [
                    'id' => 2,
                    'user_name' => 'Trần Hoàng Long',
                    'user_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                    'product_id' => 1,
                    'product_name' => 'Laptop Asus ROG Zephyrus G16 (2025) OLED',
                    'rating' => 5,
                    'created_at' => '02/10/2026',
                    'comment' => 'Máy đẹp đến ngỡ ngàng, mỏng nhẹ hơn nhiều so với các dòng gaming truyền thống. Màn OLED 240Hz màu đen sâu thăm thẳm, làm đồ họa và chơi Cyberpunk max settings cực mượt. Nhiệt độ GPU duy trì quanh 72 độ. Đáng đồng tiền bát gạo.',
                    'images' => [
                        'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=400&q=80'
                    ],
                    'likes' => 28,
                    'verified' => true,
                    'reply' => 'Dạ cảm ơn anh Long! Dòng ROG Zephyrus G16 OLED năm nay thực sự là kiệt tác công nghệ của ASUS. Nếu cần hỗ trợ thêm về phần mềm hay bảo hành, anh cứ liên hệ hotline 1800 6969 nhé!'
                ]
            ]
        ];
    }
}
