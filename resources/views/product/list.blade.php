@extends('layout')
@section('title','商品一覧')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>商品情報一覧画面</h2>
        @if (session('err_msg'))
            <p class="text-danger">{{ session('err_msg') }}</p>
        @endif
        <form  method="POST" action="search">
        @csrf
            <div style="height:40px">
                <input type="text" name="word" class="h-100" @if(session('inputWord')) Value="{{session('inputWord')}}" @endif>
                <select name="company" class="h-100">
                    <option hidden value=>メーカー名</option>
                    <option value=>指定しない</option>
                    @foreach($companies as $company){
                    <option value="{{ $company->company_name }}" @if($company->company_name == session('selectedCompany')) selected @endif>{{ $company->company_name }}</option>
                    }
                    @endforeach
                </select>
                <input type="submit" value="検索" class="h-100 btn btn-primary">
            </div>
            <br>
        </form>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($products as $product)
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
                <td><a class="btn btn-primary" href="/product/{{ $product->id }}">詳細</a></td>
                <form method="POST" action="{{ route('productDelete', $product->id) }}" onSubmit="return checkDelete()">
                @csrf
                    <td><button type="submit" class="btn btn-primary" onclick=>削除</button></td>
                </form>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection