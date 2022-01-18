<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * プロダクト一覧を表示する
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $word = $request->word;
        // フォームから受け取った検索ワードを$wordに格納

        $selectedCompany = $request->company;
        // フォームから受け取ったメーカー名セレクトボックスの内容を$selectedCompanyに格納

        $companies = Company::all();
        
        if(isset($word)||isset($selectedCompany)){
            if($word === null){
                if(isset($selectedCompany)){
                    $products = DB::table('products')
                    ->join('companies','products.company_id','=','companies.id')
                    ->select('products.*','companies.company_name')
                    ->where([['companies.company_name', 'LIKE', "%$selectedCompany%"]])
                    ->get();
                }
            }elseif($selectedCompany === null){
                if(isset($word)){
                    $products = DB::table('products')
                    ->join('companies','products.company_id','=','companies.id')
                    ->select('products.*','companies.company_name')
                    ->where([['product_name', 'LIKE', "%$word%"]])
                    ->get();
                }
            }else{
                $products = DB::table('products')
                ->join('companies','products.company_id','=','companies.id')
                ->select('products.*','companies.company_name')
                ->where([['product_name', 'LIKE', "%$word%"],['companies.company_name', 'LIKE', "$selectedCompany"]])
                ->get();
            }
        }else{
            $products = DB::table('products')
            ->join('companies','products.company_id','=','companies.id')
            ->select('products.*','companies.company_name')
            ->get();
            // dd($products);
        }
        $request->session()->flash('inputWord', "$word");
        $request->session()->flash('selectedCompany', "$selectedCompany");
        return view('product.list', ['products'=>$products],['companies'=>$companies]);
        // return view('home');
    }
}
