@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/products.css">

<div class="products-container">
    <div class="page-header">
        <h2 class="page-title">
            @if(request('search'))
                "{{ request('search') }}"の商品一覧
            @else
                商品一覧
            @endif
        </h2>
        <a href="{{ route('products.create') }}" class="add-product-btn">+ 商品を追加</a>
    </div>

    <div class="content-wrapper">
        <div class="sidebar">
            <div class="search-card">
                <!-- 検索フォーム -->
                <form action="{{ route('products.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrap">
                        <input type="text" name="search" class="search-input" placeholder="商品名で検索" value="{{ $search ?? '' }}">
                    </div>
                    <button type="submit" class="search-btn">検索</button>
                </form>

                <!-- 並び替えドロップダウン -->
                <div class="sort-section">
                    <h6 class="sort-title">価格順で表示</h6>
                    <div class="custom-dropdown">
                        <button class="dropdown-toggle" type="button">価格で並べ替え</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'high']) }}">高い順に表示</a>
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'low']) }}">低い順に表示</a>
                        </div>
                    </div>
                </div>

                <!-- 並び替えタグ -->
                @if(isset($sort))
                    <div class="sort-badge-wrap">
                        <span class="sort-badge">
                            {{ $sort === 'high' ? '高い順に表示' : '低い順に表示' }}
                            <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="sort-badge-close">×</a>
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="main-content">
            <div class="products-list">
                @foreach($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->id) }}" class="product-link">
                            <div class="product-image-wrap">
                                <img src="{{ asset('storage/img/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">{{ $product->name }}</h5>
                                <h5 class="product-price">¥{{ number_format($product->price) }}</h5>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrap">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 