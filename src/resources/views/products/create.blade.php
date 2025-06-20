@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/product-detail.css">

<div class="product-detail-container" style="position:relative;">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        <div class="product-main">
            <div class="product-image-section">
                <div class="current-image">
                    <img id="preview-image" src="" alt="" class="product-image" style="display:none;">
                </div>
                <div class="image-input-group">
                    <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg">
                </div>
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="product-info-section">
                <div class="form-group">
                    <label for="name">商品名</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="商品名を入力">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">値段</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-control" placeholder="値段を入力">
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>季節</label>
                    <div class="season-checkboxes">
                        @php
                            $selectedSeasons = old('seasons', []);
                        @endphp
                        @foreach(['春', '夏', '秋', '冬'] as $season)
                            <label class="season-checkbox">
                                <input type="checkbox" name="seasons[]" value="{{ $season }}" {{ in_array($season, $selectedSeasons) ? 'checked' : '' }}>
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
            <textarea id="description" name="description" class="form-control" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-actions">
            <a href="{{ route('products.index') }}" class="back-btn">戻る</a>
            <button type="submit" class="save-btn">登録</button>
        </div>
    </form>
</div>
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview-image');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.src = ev.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>
@endsection 