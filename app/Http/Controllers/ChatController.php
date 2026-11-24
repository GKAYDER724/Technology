<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ChatController extends Controller
{

    public function index()
    {

        if(Auth::check()){

            /** @var User $user */
            $user = Auth::user();

            $user->last_seen = Carbon::now();
            $user->save();

        }



        // Đánh dấu tin nhắn admin đã đọc

        ChatMessage::where('user_id', Auth::id())
            ->where('sender','admin')
            ->update([
                'is_read'=>1
            ]);




        // Lấy tin nhắn

        $messages = ChatMessage::where('user_id',Auth::id())
            ->orderBy('chat_message_id','asc')
            ->get();




        // Lấy admin online gần nhất

        $admin = User::whereIn('role_id',[1,2])
            ->where('status','active')
            ->orderByDesc('last_seen')
            ->first();




        return view('chat.index',compact(
            'messages',
            'admin'
        ));

    }






    public function store(Request $request)
    {

        $request->validate([

            'message'=>'required|string|max:1000'

        ]);




        // cập nhật thời gian online

        if(Auth::check()){


            /** @var User $user */

            $user = Auth::user();

            $user->last_seen = Carbon::now();

            $user->save();


        }





        // lưu tin nhắn khách

        ChatMessage::create([

            'user_id'=>Auth::id(),

            'sender'=>'customer',

            'message'=>$request->message,

            'is_read'=>0

        ]);






        /*
        ==========================
              AI CHATBOT
        ==========================
        */



        $message = mb_strtolower($request->message);



$reply = $this->findProduct($message);

if(!$reply){

    $reply = $this->aiReply($message);

}





        // lưu phản hồi AI

        if($reply){


            ChatMessage::create([

                'user_id'=>Auth::id(),

                'sender'=>'ai',

                'message'=>$reply,

                'is_read'=>0

            ]);

        }





        return redirect()->route('chat.index');


    }








    // API realtime lấy tin nhắn

    public function messages()
    {

        $messages = ChatMessage::where('user_id',Auth::id())

            ->orderBy('chat_message_id','asc')

            ->get();



        return response()->json($messages);

    }









    // AI trả lời tự động

    private function aiReply($message)
    {


        // Chào hỏi

        if(
            str_contains($message,'xin chào') ||
            str_contains($message,'hello') ||
            $message=='hi' ||
            $message=='hey'
        ){

            return "Dạ em chào anh/chị 👋 ElectroTech có thể hỗ trợ tư vấn laptop, giá sản phẩm, cấu hình và chính sách bảo hành ạ. Anh/chị đang quan tâm laptop dùng cho công việc gì vậy ạ?";

        }







        // Sinh viên IT

        if(
            str_contains($message,'sinh viên') ||
            str_contains($message,'sinh vien') ||
            str_contains($message,'code') ||
            str_contains($message,'lập trình') ||
            str_contains($message,'lap trinh')
        ){


            return "Dạ nếu anh/chị học IT hoặc lập trình thì nên ưu tiên laptop RAM từ 16GB, CPU Core i5 hoặc Ryzen 5 trở lên để chạy VS Code, database và máy ảo ổn định ạ. Anh/chị đang học ngành nào và ngân sách khoảng bao nhiêu để em tư vấn mẫu phù hợp hơn ạ?";


        }








        // Giá sản phẩm

        if(
            str_contains($message,'giá') ||
            str_contains($message,'bao nhiêu') ||
            str_contains($message,'bao nhieu')
        ){


            return "Dạ ElectroTech có nhiều phân khúc laptop khác nhau ạ. Anh/chị cho em xin nhu cầu sử dụng và ngân sách để em tư vấn mẫu phù hợp nhất nhé.";


        }









        // Gaming

        if(
            str_contains($message,'game') ||
            str_contains($message,'gaming') ||
            str_contains($message,'chơi game')
        ){


            return "Dạ nếu anh/chị cần laptop gaming thì nên ưu tiên CPU mạnh, RAM 16GB trở lên và card đồ họa rời RTX để chơi game và làm việc tốt hơn ạ. Anh/chị thường chơi game nào và ngân sách khoảng bao nhiêu vậy ạ?";


        }








        // Đồ họa

        if(
            str_contains($message,'photoshop') ||
            str_contains($message,'thiết kế') ||
            str_contains($message,'design')
        ){


            return "Dạ nhu cầu thiết kế đồ họa nên chọn máy có RAM từ 16GB, màn hình màu tốt và card đồ họa phù hợp ạ. Anh/chị thường dùng Photoshop, Illustrator hay dựng video vậy ạ?";


        }








        // Bảo hành

        if(str_contains($message,'bảo hành')){


            return "Dạ sản phẩm ElectroTech được hỗ trợ bảo hành theo từng sản phẩm ạ. Anh/chị gửi giúp em tên hoặc mã laptop để em kiểm tra chi tiết nhé.";


        }








        // Giao hàng

        if(
            str_contains($message,'ship') ||
            str_contains($message,'giao')
        ){


            return "Dạ ElectroTech có hỗ trợ giao hàng ạ. Anh/chị cho em xin khu vực nhận hàng để em kiểm tra thời gian giao dự kiến nhé.";


        }








        // Cấu hình

        if(
            str_contains($message,'ram') ||
            str_contains($message,'ssd') ||
            str_contains($message,'cấu hình') ||
            str_contains($message,'cau hinh')
        ){


            return "Dạ cấu hình laptop sẽ tùy theo nhu cầu sử dụng ạ. Anh/chị cần máy để học tập, lập trình, văn phòng hay chơi game để em tư vấn chính xác hơn nhé.";


        }







        // Không hiểu

        return "Dạ em chưa hiểu rõ nhu cầu của anh/chị ạ 😅 Anh/chị có thể cho em biết mục đích sử dụng, ngân sách và yêu cầu mong muốn để ElectroTech tư vấn tốt hơn nhé.";

    }
private function findProduct($message)
{
    $hasIntent = false;


$intentWords = [
    'laptop',
    'máy',
    'may',
    'gaming',
    'game',
    'it',
    'code',
    'lập trình',
    'lap trinh',
    'sinh viên',
    'sinh vien',
    'văn phòng',
    'van phong',
    'office',
    'triệu',
    'trieu',
    'giá', 
    'gia',
    // Điện thoại
'điện thoại',
'dien thoai',
'iphone',
'samsung',
'phone',
'android',

// Phụ kiện
'phụ kiện',
'phu kien',
'tai nghe',
'chuột',
'chuot',
'bàn phím',
'ban phim',
'sạc',
'sac',
'cáp',
'cap'
];


foreach($intentWords as $word){

    if(str_contains($message,$word)){

        $hasIntent = true;
        break;

    }

}


if(!$hasIntent){

    return null;

}
    $minPrice = null;
    $maxPrice = null;


    // =========================
    // PHÂN TÍCH GIÁ
    // =========================

    if(
        preg_match('/(\d+)\s*(?:đến|-|toi|tới)\s*(\d+)\s*(triệu|trieu)/u', $message, $match)
    ){

        $minPrice = $match[1] * 1000000;
        $maxPrice = $match[2] * 1000000;

    }
    elseif(
        preg_match('/(?:dưới|duoi)\s*(\d+)\s*(triệu|trieu)/u', $message, $match)
    ){

        $maxPrice = $match[1] * 1000000;

    }
    elseif(
        preg_match('/(?:trên|tren)\s*(\d+)\s*(triệu|trieu)/u', $message, $match)
    ){

        $minPrice = $match[1] * 1000000;

    }
    elseif(
        preg_match('/(\d+)\s*(triệu|trieu|củ|cu)/u', $message, $match)
    ){

        $price = $match[1] * 1000000;

        $minPrice = $price - 5000000;
        $maxPrice = $price + 5000000;

    }



    // =========================
    // PHÂN TÍCH NHU CẦU
    // =========================

    $need = null;
    $type = "all";


if(
    str_contains($message,'iphone') ||
    str_contains($message,'samsung') ||
    str_contains($message,'android') ||
    str_contains($message,'điện thoại') ||
    str_contains($message,'dien thoai') ||
    str_contains($message,'phone')
){

    $type = "phone";

}


if(
    str_contains($message,'phụ kiện') ||
    str_contains($message,'phu kien') ||
    str_contains($message,'tai nghe') ||
    str_contains($message,'chuột') ||
    str_contains($message,'chuot') ||
    str_contains($message,'bàn phím') ||
    str_contains($message,'sạc') ||
    str_contains($message,'cap')
){

    $type = "accessory";

}

    if(
        str_contains($message,'gaming') ||
        str_contains($message,'game') ||
        str_contains($message,'chơi game')
    ){

        $need = "gaming";

    }
    elseif(
        str_contains($message,'it') ||
        str_contains($message,'code') ||
        str_contains($message,'lập trình') ||
        str_contains($message,'lap trinh')
    ){

        $need = "it";

    }
    elseif(
        str_contains($message,'văn phòng') ||
        str_contains($message,'van phong') ||
        str_contains($message,'office')
    ){

        $need = "office";

    }



    // =========================
    // LẤY SẢN PHẨM
    // =========================

    $products = Product::with([
    'variants',
    'primaryImage'
])
->where('status','active');
if($type == "phone"){

    $products->where(function($query){

        $query
        ->where('name','like','%iPhone%')
        ->orWhere('name','like','%Samsung%')
        ->orWhere('name','like','%Phone%')
        ->orWhere('name','like','%Điện thoại%');

    });

}



if($type == "accessory"){

    $products->where(function($query){

        $query
        ->where('name','like','%Tai nghe%')
        ->orWhere('name','like','%Chuột%')
        ->orWhere('name','like','%Bàn phím%')
        ->orWhere('name','like','%Sạc%')
        ->orWhere('name','like','%Cáp%')
        ->orWhere('name','like','%Phụ kiện%');

    });

}


    // =========================
    // LỌC GIÁ DATABASE
    // =========================

    if($minPrice !== null || $maxPrice !== null){

        $products->where(function($query) use ($minPrice,$maxPrice){


            if($minPrice !== null){

                $query->where(function($q) use ($minPrice){

                    $q->where('sale_price','>=',$minPrice)
                    ->orWhere(function($sub) use ($minPrice){

                        $sub->whereNull('sale_price')
                        ->where('base_price','>=',$minPrice);

                    });

                });

            }



            if($maxPrice !== null){

                $query->where(function($q) use ($maxPrice){

                    $q->where('sale_price','<=',$maxPrice)
                    ->orWhere(function($sub) use ($maxPrice){

                        $sub->whereNull('sale_price')
                        ->where('base_price','<=',$maxPrice);

                    });

                });

            }


        });

    }



    // =========================
    // TỪ KHÓA
    // =========================

   $ignoreWords = [

    'cần',
    'can',

    'sinh',
    'viên',
    'vien',

    'muốn',
    'muon',
    'cần',
    'cho',

    'laptop',
    'máy',
    'may',

    'gaming',
    'game',

    'it',
    'code',

    'văn',
    'phòng',
    'van',
    'phong',

    'triệu',
    'trieu',

    'dưới',
    'duoi',

    'trên',
    'tren',

    'khoảng',
    'khoang',

    'đến',
    'toi',
    'tới',

    'giá',
    'gia',

    'lập',
    'trình',
    'lap',
    'trinh',

];



    $keywords = preg_split('/\s+/', trim($message));


$searchWords = [];

foreach($keywords as $word){

    $word = trim($word);


    if(
    (
        mb_strlen($word) >= 4
        || is_numeric($word)
    )
    &&
    !in_array($word,$ignoreWords)
){

        $searchWords[] = $word;

    }

}

if(count($searchWords)==0){

    $products->limit(3);

}

if(count($searchWords)>0){

    $products->where(function($query) use ($searchWords){

        foreach($searchWords as $word){

            if(!is_numeric($word)){

                $query->orWhere(
                    'name',
                    'like',
                    "%".$word."%"
                );

            }

        }

    });

}



    // =========================
    // ƯU TIÊN
    // =========================

if($need == "gaming"){

$products->orderByRaw("
CASE
WHEN name LIKE '%Gaming%'
OR name LIKE '%RTX%'
OR name LIKE '%TUF%'
THEN 1
ELSE 2
END
");

}

    if($need == "it" || $need == "office"){

        $products->orderByRaw("
            CASE
                WHEN name LIKE '%Pro%'
                OR name LIKE '%Office%'
                OR name LIKE '%Business%'
                THEN 1
                ELSE 2
            END
        ");

    }



    $products = $products->get();



    // =========================
    // LỌC GIÁ LẦN CUỐI
    // =========================

    if($minPrice !== null || $maxPrice !== null){


        $products = $products->filter(function($product) use ($minPrice,$maxPrice){


            $price = $product->sale_price
                ?? $product->base_price;


            if($product->variants->count()){

                $price = $product->variants->min(function($variant){

                    return $variant->sale_price
                    ?? $variant->price;

                });

            }



            if($minPrice !== null && $price < $minPrice){

                return false;

            }


            if($maxPrice !== null && $price > $maxPrice){

                return false;

            }


            return true;


        });

    }


    
    if($products->count()==0){

        return null;

    }
    $products = $products
    ->unique('product_id')
    ->take(3);


    // =========================
    // TẠO CÂU TRẢ LỜI
    // =========================

    $reply = "Dạ ElectroTech tìm được sản phẩm phù hợp với nhu cầu của anh/chị ạ:\n\n";



    foreach($products as $product){


        $price = $product->sale_price
            ?? $product->base_price;



        if($product->variants->count()){

            $price = $product->variants->min(function($variant){

                return $variant->sale_price
                ?? $variant->price;

            });

        }



        if($type=="phone"){

    $reply .= "📱 ".$product->name."\n";

}
elseif($type=="accessory"){

    $reply .= "🎧 ".$product->name."\n";

}
else{

    $reply .= "💻 ".$product->name."\n";

}


        $reply .= "💰 Giá từ: "
            .number_format($price)
            ." VNĐ\n";



        if($product->description){

            $reply .= "📝 Mô tả: "
                .strip_tags($product->description)
                ."\n";

        }



        if($product->variants->count()){


            $reply .= "⚙️ Cấu hình:\n";


            foreach($product->variants->take(3) as $variant){


                $variantPrice = $variant->sale_price
                    ?? $variant->price;


                $reply .= "- "
                    .$variant->variant_name
                    ." | "
                    .number_format($variantPrice)
                    ." VNĐ\n";


            }

        }



        $stock = $product->stock;


        if($product->variants->count()){

            $stock = $product->variants->sum('stock');

        }



        $reply .= "📦 Còn lại: "
            .$stock
            ." sản phẩm\n";


        


    }



    return $reply;
}

}