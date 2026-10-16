<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * Trang tổng quan bảo hành.
     */
    public function index()
    {
        return view('warranty.index');
    }

    /**
     * Trang tạo yêu cầu bảo hành.
     */
    public function create()
    {
        return view('warranty.create');
    }

    /**
     * Trang tra cứu trạng thái bảo hành.
     */
    public function status()
    {
        return view('warranty.status');
    }

    /**
     * Trang lịch sử bảo hành.
     */
    public function history()
    {
        return view('warranty.history');
    }
}

