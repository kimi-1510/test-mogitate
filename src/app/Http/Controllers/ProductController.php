<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Season;

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
        return view('products.show', compact('product'));
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

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $data = $request->validated();
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image) {
                Storage::disk('public')->delete('img/' . $product->image);
            }
            // 新しい画像を保存
            $filename = $request->file('image')->hashName();
            $request->file('image')->storeAs('img', $filename, 'public');
            $data['image'] = $filename;
        }
        
        $product->update($data);
        
        return redirect()->route('products.index')
            ->with('success', '商品情報を更新しました');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        
        // 画像を削除
        if ($product->image) {
            Storage::disk('public')->delete('img/' . $product->image);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', '商品を削除しました');
    }

    /**
     * 商品を新規登録
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        // 画像保存
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->hashName();
            $request->file('image')->storeAs('img', $filename, 'public');
            $data['image'] = $filename;
        }

        // 商品本体保存
        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'image' => $data['image'],
            'description' => $data['description'],
        ]);

        // 季節（多対多）保存
        $seasonIds = Season::whereIn('name', $data['seasons'])->pluck('id')->toArray();
        $product->seasons()->sync($seasonIds);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }
}
