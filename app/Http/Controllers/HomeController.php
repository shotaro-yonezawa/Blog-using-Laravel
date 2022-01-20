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

        $companies = new Company;
        $products = new Product;
        $allCompany = $companies->getCompanies();
        
        if(isset($word)||isset($selectedCompany)){
            if($word === null){
                if(isset($selectedCompany)){
                    $selectedProducts = $products->getProductsByCompany($selectedCompany);
                }
            }elseif($selectedCompany === null){
                if(isset($word)){
                    $selectedProducts = $products->getProductsByWord($word);
                }
            }else{
                $selectedProducts = $products->getProductsByWordAndCompany($word,$selectedCompany);
            }
        }else{
            $selectedProducts = $products->getProducts();
        }
        $request->session()->flash('inputWord', "$word");
        $request->session()->flash('selectedCompany', "$selectedCompany");
        return view('product.list', ['products'=>$selectedProducts],['companies'=>$allCompany]);
        // return view('home');
    }
}
