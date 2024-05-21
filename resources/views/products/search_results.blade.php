@foreach($searchResults as $product)
<tr id="product-row">
    <td>{{ $product->id }}</td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->company->company_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="50" height="75"></td>
    <td>
        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
        <form method="POST" action="/products/{{ $product->id }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button data-product-id="{{ $product->id }}" class="delete-product btn btn-danger btn-sm mx-1" type="submit">削除</button>
        </form>
    </td>
</tr>
@endforeach
