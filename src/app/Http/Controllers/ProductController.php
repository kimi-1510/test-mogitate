<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 商品一覧を表示
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索機能
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // 並び替え機能
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'high') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'low') {
                $query->orderBy('price', 'asc');
            }
        }

        // ページネーション（6件ごと）
        $products = $query->paginate(6);

        return view('products.index', [
            'products' => $products,
            'search' => $request->input('search'),
            'sort' => $request->input('sort')
        ]);
    }

    /**
     * 商品詳細を表示
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', ['product' => $product]);
    }

    /**
     * 商品登録画面を表示
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * 商品更新画面を表示
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    /**
     * 商品を削除
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
