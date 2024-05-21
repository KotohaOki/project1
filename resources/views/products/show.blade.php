@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">商品情報詳細</h2>

    <dl class="row mt-3">
        <dt class="col-sm-2">ID :</dt>
        <dd class="col-sm-9">{{ $product->id }}</dd>

        <dt class="col-sm-2">商品名 :</dt>
        <dd class="col-sm-9">{{ $product->product_name }}</dd>

        <dt class="col-sm-2">メーカー名 :</dt>
        <dd class="col-sm-9">{{ $product->company->company_name }}</dd>

        <dt class="col-sm-2">価格 :</dt>
        <dd class="col-sm-9">{{ $product->price }}</dd>

        <dt class="col-sm-2">在庫数 :</dt>
        <dd class="col-sm-9">{{ $product->stock }}</dd>

        <dt class="col-sm-2">コメント :</dt>
        <dd class="col-sm-9">{{ $product->comment }}</dd>

        <dt class="col-sm-2">商品画像 :</dt>
        <dd class="col-sm-9"><img src="{{ asset($product->img_path) }}" width="150" height="200"></dd>
    </dl>

    <td>
    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm mx-1">商品一覧に戻る</a>
    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a>
    </td>

</div>
@endsection
