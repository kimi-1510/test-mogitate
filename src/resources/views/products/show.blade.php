@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/product-detail.css">

<div class="product-detail-container" style="position:relative;">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        @method('PUT')

        <div class="product-main">
            <div class="product-image-section">
                <div class="breadcrumb">
                    <a href="{{ route('products.index') }}">商品一覧</a> &gt; <span>{{ $product->name }}</span>
                </div>
                <div class="current-image">
                    @if($product->image)
                        <img src="{{ asset('storage/img/' . $product->image) }}" alt="現在の商品画像" class="product-image">
                    @endif
                </div>
                <input type="file" id="image" name="image" class="form-control">
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="product-info-section">
                <div class="form-group">
                    <label for="name">商品名</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form-control">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">値段</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="form-control">
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>季節</label>
                    <div class="season-checkboxes">
                        @php
                            $selectedSeasons = old('seasons');
                            if ($selectedSeasons === null) {
                                $selectedSeasons = $product->seasons->pluck('name')->toArray();
                            }
                        @endphp
                        @foreach(['春', '夏', '秋', '冬'] as $season)
                            <label class="season-checkbox">
                                <input type="checkbox" name="seasons[]" value="{{ $season }}"
                                    {{ in_array($season, $selectedSeasons) ? 'checked' : '' }}>
                                {{ $season }}
                            </label>
                        @endforeach
                    </div>
                    @error('seasons')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group description-group">
            <label for="description">商品説明</label>
            <textarea id="description" name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('products.index') }}" class="back-btn">戻る</a>
            <button type="submit" class="save-btn">変更を保存</button>
        </div>
        <!-- 削除ボタンを右下に絶対配置 -->
        <button type="submit" form="delete-form" class="delete-btn-inside" onclick="return confirm('本当に削除しますか？')">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
              <g>
                <path d="M10 12h20M16 16v10M20 16v10M24 16v10M8 12v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V12M14 12V8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v4" stroke="#e74c3c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
              </g>
            </svg>
        </button>
    </form>
    <!-- 削除用formは外に出す -->
    <form id="delete-form" action="{{ route('products.delete', $product->id) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection 