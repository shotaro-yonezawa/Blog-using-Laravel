@extends('layout')
@section('title','商品詳細')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>{{ $product->product_name }}</h2>
        <p class="text-right">作成日：{{ $product->created_at }}</p>
        <p class="text-right">更新日：{{ $product->updated_at }}</p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
            </tr>
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if(!empty($product->product_image))
                    <img class="product_image" src="{{ Storage::url($product->product_image) }}" alt="" width="100px" height="100px">
                    @endif
                </td>
                <td>{{ $product->product_name }}</td>
                <td>¥ {{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company_name }}</td>
            </tr>
        </table>

        <br>
        <p>コメント：</p>
        <div>
            @if(!empty($product->product_image))
            <img class="product_image" src="{{ Storage::url($product->product_image) }}" alt="" width="100px" height="100px">
            @endif
        </div>
        <p>{{ $product->comment }}</p>
        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('home') }}'">戻る</button>
        <button type="button" class="btn btn-primary float-right" onclick="location.href='/product/edit/{{$product->id}}'">編集</button>
    </div>
</div>
@endsection