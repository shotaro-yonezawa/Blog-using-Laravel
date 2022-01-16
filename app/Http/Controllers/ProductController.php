<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * プロダクト一覧を表示する
     * 
     * @return view
     */
    // public function showList(){
    //     if (Auth::check()) {
    //         // ユーザーはログインしている
    //             $companies = Company::all();
    //             $products = Product::all();
    //             return view('product.list', ['products'=>$products],['companies'=>$companies]);
    //     }else{
    //         return redirect(route('home'));
    //     }
    // }

    /**
     * プロダクト詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id){
        if (Auth::check()){
            // $product = Product::find($id);
            $companies = Company::all();
            $product = DB::table('products')
            ->join('companies','products.company_id','=','companies.id')
            ->select('products.*','companies.company_name')
            ->where('products.id','=',$id)
            ->first();

            if(is_null($product)){
                \Session::flash('err_msg','データがありません');
                return redirect(route('products'));
            }
            if(is_null($companies)){
                \Session::flash('err_msg','データがありません');
                return redirect(route('products'));
            }
            return view('product.detail',['product'=>$product],['companies'=>$companies]);
        }else{
            return redirect(route('home'));
        }
    }
    
    /**
     * プロダクト登録画面を表示する
     * 
     * @return view
     */
    public function showCreate(){
        if (Auth::check()){
            $companies = Company::all();
            return view('product.form',['companies'=>$companies]);
        }else{
            return redirect(route('home'));
        }
    }
    
    /**
     * プロダクト登録
     * 
     * @return view
     */
    public function exeStore(ProductRequest $request){
        if (Auth::check()) {
            // プロダクトのデータを受け取る
            // $inputs = $request->all();
            $productImage = $request->product_image;
            \DB::beginTransaction();
            try{
                if ($productImage) {
                    //一意のファイル名を自動生成しつつ保存し、かつファイルパス（$productImagePath）を生成
                    //ここでstore()メソッドを使っているが、これは画像データをstorageに保存している
                    $productImagePath = $productImage->store('public/uploads');
                    // dd($productImagePath);
                } else {
                    $productImagePath = "";
                }
                $data = [
                    // 'id'=> $request->id,
                    '_token'=> $request->_token,
                    'company_id'=> $request->company_id,
                    'product_name'=> $request->product_name,
                    'price'=> $request->price,
                    'stock'=> $request->stock,
                    'comment'=> $request->comment,
                    'product_image'=> $productImagePath
                ];
                // プロダクトを登録
                Product::create($data);
                \DB::commit();
            }catch(\Throwable $e){
                \DB::rollback();
                abort(500);
            }
            \Session::flash('err_msg','プロダクトを登録しました');
            return redirect(route('home'));
        }else{
            return redirect(route('home'));
        }
        
    }
    
    /**
     * プロダクト編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id){
        if (Auth::check()) {
            $companies = Company::all();
            $product = DB::table('products')
            ->join('companies','products.company_id','=','companies.id')
            ->select('products.*','companies.company_name')
            ->where('products.id','=',$id)
            ->first();

            // $product = Product::find($id);
            if(is_null($product)){
                \Session::flash('err_msg','データがありません');
                return redirect(route('home'));
            }
            // dd($product);
            return view('product.edit', ['product'=>$product],['companies'=>$companies]);
        }else{
            return redirect(route('home'));
        }
    }

    /**
     * プロダクト編集
     * 
     * @return view
     */
    public function exeUpdate(ProductRequest $request){
        if (Auth::check()) {
            // プロダクトのデータを受け取る
            $inputs = $request->all();
            $productImage = $request->product_image;
            $inputs = Arr::add($inputs,'product_image', null);
            \DB::beginTransaction();
            try{
                if ($productImage) {
                    //一意のファイル名を自動生成しつつ保存し、かつファイルパス（$productImagePath）を生成
                    //ここでstore()メソッドを使っているが、これは画像データをstorageに保存している
                    $productImagePath = $productImage->store('public/uploads');
                } else {
                    $productImagePath = "";
                }
                
                // プロダクトを登録
                $product = Product::find($inputs['id']);
                $product->fill([
                    'product_name'=>$inputs['product_name'],
                    'company_id'=>$inputs['company_id'],
                    'price'=>$inputs['price'],
                    'stock'=>$inputs['stock'],
                    'comment'=>$inputs['comment'],
                    'product_image'=> $productImagePath
                ]);
                $product->save();
                \DB::commit();
            }catch(\Throwable $e){
                \DB::rollback();
                abort(500);
            }
            \Session::flash('err_msg','プロダクトを更新しました');
            return redirect(route('home'));
        }else{
            return redirect(route('home'));
        }
    }

    /**
     * プロダクト削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id){
        if (Auth::check()) {
            if(empty($id)){
                \Session::flash('err_msg','データがありません');
                return redirect(route('home'));
            }
            try{
                // プロダクトを削除
                Product::destroy($id);
            }catch(\Throwable $e){
                abort(500);
            }
            \Session::flash('err_msg','削除しました');
            return redirect(route('home'));
        }else{
            return redirect(route('home'));
        }
    }
    
}
