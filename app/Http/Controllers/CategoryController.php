<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Lấy danh sách danh mục phân cấp cha - con dạng cây (Tree) dưới dạng JSON API.
     */
    public function index(): JsonResponse
    {
        // Lấy các danh mục gốc (parent_id là null) kèm theo danh mục con cấp trực thuộc
        $categories = Category::whereNull('parent_id')
            ->with('children') // Dùng 'children.children' nếu muốn đệ quy sâu hơn nhiều cấp
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách danh mục thành công',
            'data' => $categories
        ]);
    }
}