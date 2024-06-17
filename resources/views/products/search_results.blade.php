@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-3">商品情報一覧</h2>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">新規登録</a>

    <div class="search mt-3">
    <h5>絞り込み検索:</h5>
        <form id="search_form" action="{{ route('products.index') }}" method="GET" class="row g-3">
        @csrf
            <div class="row mt-3">
                <div class="col-sm-12 col-md-3">
                    <input type="text" class="form-control" id="product_search" name="product_search"  placeholder="商品名" value="{{ request('product_search') }}">
                </div>

                <div class="col-sm-12 col-md-3">
                    <select class="form-select" id="company_search" name="company_search">
                        <option value="">メーカー名</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-1">
                <!-- 最小価格の入力欄 -->
                <div class="col-sm-12 col-md-2">
                    <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
                </div>
                <!-- 最大価格の入力欄 -->
                <div class="col-sm-12 col-md-2">
                    <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
                </div>
                <!-- 最小在庫数の入力欄 -->
                <div class="col-sm-12 col-md-2">
                    <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
                </div>
                <!-- 最大在庫数の入力欄 -->
                <div class="col-sm-12 col-md-2">
                    <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
                </div>

                <div class="col-sm-12 col-md-1">
                    <button id="search_btn" class="btn btn-primary" type="submit">検索</button>
                </div>
                <div class="col-sm-12 col-md-2"><!-- 検索条件をリセットするためのリンクボタン -->
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">元に戻す</a>
                </div>
            </div>
        </form>
    </div>

    <div id="search_results" class="products mt-5">
        <table class="table table-striped">
            @foreach ($searchResults as $product)
            <thead>
                <tr>
                    <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => $sortColumn == 'id' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">ID</a></th>
                    <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'product_name', 'order' => $sortColumn == 'product_name' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">商品名</a></th>
                    <th>メーカー名</th>
                    <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => $sortColumn == 'price' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">価格</a></th>
                    <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'order' => $sortColumn == 'stock' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}">在庫数</th>
                    <th>商品画像</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <tr id="product-row">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="50" height="75"></td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}"  class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button data-product-id="{{ $product->id }}" class="delete-product btn btn-danger btn-sm mx-1" type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $products->appends(request()->query())->links() }}

</div>
@endsection
