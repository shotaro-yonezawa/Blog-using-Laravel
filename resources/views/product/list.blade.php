@extends('ajaxLayout')
@section('title','商品一覧')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h2>商品情報一覧画面</h2>
        @if (session('err_msg'))
        <p class="text-danger">{{ session('err_msg') }}</p>
        @endif
        <div class="container">
            <div class="row">
                <div class="col">
                    <span>値段：</span>
                    <label for="upperPriceLimit">上限</label>
                    <input id="upperPriceLimit" type="number" name="upperPriceLimit" style="width:100px" min="0" max="9999" maxlength="4">
                    <span>-</span>
                    <label for="lowerPriceLimit">下限</label>
                    <input id="lowerPriceLimit" type="number" name="lowerPriceLimit" style="width:100px" min="0" max="9999">
                    <br>
                    <span>在庫：</span>
                    <label for="upperStockLimit">上限</label>
                    <input id="upperStockLimit" type="number" name="upperStockLimit" style="width:100px" min="0" max="9999">
                    <span>-</span>
                    <label for="lowerStockLimit">下限</label>
                    <input id="lowerStockLimit" type="number" name="lowerStockLimit" style="width:100px" min="0" max="9999">
                </div>
                <div class="col" style="height:40px">
                    <input id="word" type="text" name="word" class="h-100" placeholder="検索ワード">
                    <select id="company" name="company" class="h-100">
                        <option hidden value=>メーカー名</option>
                        <option value=>指定しない</option>
                        @foreach($companies as $company){
                        <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                        }
                        @endforeach
                    </select>
                    <input id="ajaxSearch" type="submit" value="検索" class="h-100 btn btn-primary">
                </div>
            </div>
        </div>
        <br>
        <table class="table table-striped home">
            <thead>
                <tr>
                    <th><button data-pressed="id" data-sort="asc" type="button" class="btn sortButton">ID</button></th>
                    <th>商品画像</th>
                    <th><button data-pressed="product_name" data-sort="asc" type="button" class="btn sortButton">商品名</button></th>
                    <th><button data-pressed="price" data-sort="asc" type="button" class="btn sortButton">価格</button></th>
                    <th><button data-pressed="stock" data-sort="asc" type="button" class="btn sortButton">在庫数</button></th>
                    <th><button data-pressed="company_name" data-sort="asc" type="button" class="btn sortButton">メーカー名</button></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="productList"></tbody>
        </table>
        <br>
        <input id="storedWord" name="storedWord" type="hidden">
        <input id="storedCompany" name="storedCompany" type="hidden">
        <input id="storedUpperPriceLimit" name="storedUpperPriceLimit" type="hidden">
        <input id="storedLowerPriceLimit" name="storedLowerPriceLimit" type="hidden">
        <input id="storedUpperStockLimit" name="storedUpperStockLimit" type="hidden">
        <input id="storedLowerStockLimit" name="storedLowerStockLimit" type="hidden">
        <input id="storedPressedButton" name="storedPressedButton" type="hidden">
        <input id="storedSortToggle" name="storedSortToggle" type="hidden">
    </div>
</div>
@endsection