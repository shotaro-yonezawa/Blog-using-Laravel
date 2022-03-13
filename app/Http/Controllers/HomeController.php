<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * @param Illuminate\Http\Request
     * @return view
     */
    public function index(Request $request)
    {
        $companies = new Company;
        $allCompany = $companies->getCompanies();
        return view('product.list', ['companies'=>$allCompany]);
    }

    /**
     * プロダクト一覧をjson形式で返す
     * 
     * @return json
     */
    public function ajaxGet(){
        $products = new Product;
        $selectedProducts = $products->getProducts();
        return response()->json($selectedProducts); //JSONデータをjQueryに返す
    }

    /**
     * プロダクトの検索結果をjson形式で返す
     * @param Illuminate\Http\Request
     * @return json
     */
    public function ajaxSearch(Request $request){
        $word = $request->word;
        $selectedCompany = $request->company;
        $upperPriceLimit = $request->upperPriceLimit;
        $lowerPriceLimit = $request->lowerPriceLimit;
        $upperStockLimit = $request->upperStockLimit;
        $lowerStockLimit = $request->lowerStockLimit;
        $pressedButton = 'id';
        $sortToggle = 'asc';
        $companies = new Company;
        $products = new Product;
        $allCompany = $companies->getCompanies();
        
        // 値が入力されなかった場合の値を設定
        if(!isset($upperPriceLimit)){
            $upperPriceLimit = 9999;
        }
        if(!isset($lowerPriceLimit)){
            $lowerPriceLimit = 0;
        }
        if(!isset($upperStockLimit)){
            $upperStockLimit = 9999;
        }
        if(!isset($lowerStockLimit)){
            $lowerStockLimit = 0;
        }
        $upperPriceLimit = (int)$upperPriceLimit;
        $lowerPriceLimit = (int)$lowerPriceLimit;
        $upperStockLimit = (int)$upperStockLimit;
        $lowerStockLimit = (int)$lowerStockLimit;

        if(!isset($word)){
            $word = '%';
        }
        if(!isset($selectedCompany)){
            $selectedCompany = '%';
        }

        $selectedProducts = $products->searchProducts($word,$selectedCompany,$upperPriceLimit,$lowerPriceLimit,$upperStockLimit,$lowerStockLimit,$pressedButton,$sortToggle);

        // デバッグ用ログ出力
        // log::debug('word:'.$word.' type:'.gettype($word));
        // log::debug('selectedCompany:'.$selectedCompany.' type:'.gettype($selectedCompany));
        // log::debug('upperPriceLimit:'.$upperPriceLimit.' type:'.gettype($upperPriceLimit));
        // log::debug('lowerPriceLimit:'.$lowerPriceLimit.' type:'.gettype($lowerPriceLimit));
        // log::debug('upperStockLimit:'.$upperStockLimit.' type:'.gettype($upperStockLimit));
        // log::debug('lowerStockLimit:'.$lowerStockLimit.' type:'.gettype($lowerStockLimit));
        // log::debug('pressedButton:'.$pressedButton.' type:'.gettype($pressedButton));
        // log::debug('sortToggle:'.$sortToggle.' type:'.gettype($sortToggle));
        return response()->json($selectedProducts);
    }

    /**
     * プロダクトのソート結果をjson形式で返す
     * @param Illuminate\Http\Request
     * @return json
     */
    public function ajaxSort(Request $request){
        $word = $request->word;
        $selectedCompany = $request->company;
        $upperPriceLimit = $request->upperPriceLimit;
        $lowerPriceLimit = $request->lowerPriceLimit;
        $upperStockLimit = $request->upperStockLimit;
        $lowerStockLimit = $request->lowerStockLimit;
        $pressedButton = $request->pressedButton;
        $sortToggle = $request->sortToggle;
        $companies = new Company;
        $products = new Product;
        $allCompany = $companies->getCompanies();
        
        // 値が入力されなかった場合の値を設定
        if(!isset($upperPriceLimit)){
            $upperPriceLimit = 9999;
        }
        if(!isset($lowerPriceLimit)){
            $lowerPriceLimit = 0;
        }
        if(!isset($upperStockLimit)){
            $upperStockLimit = 9999;
        }
        if(!isset($lowerStockLimit)){
            $lowerStockLimit = 0;
        }
        $upperPriceLimit = (int)$upperPriceLimit;
        $lowerPriceLimit = (int)$lowerPriceLimit;
        $upperStockLimit = (int)$upperStockLimit;
        $lowerStockLimit = (int)$lowerStockLimit;

        if(!isset($word)){
            $word = '%';
        }
        if(!isset($selectedCompany)){
            $selectedCompany = '%';
        }
        $selectedProducts = $products->searchProducts($word,$selectedCompany,$upperPriceLimit,$lowerPriceLimit,$upperStockLimit,$lowerStockLimit,$pressedButton,$sortToggle);

        // デバッグ用ログ出力
        // log::debug('word:'.$word.' type:'.gettype($word));
        // log::debug('selectedCompany:'.$selectedCompany.' type:'.gettype($selectedCompany));
        // log::debug('upperPriceLimit:'.$upperPriceLimit.' type:'.gettype($upperPriceLimit));
        // log::debug('lowerPriceLimit:'.$lowerPriceLimit.' type:'.gettype($lowerPriceLimit));
        // log::debug('upperStockLimit:'.$upperStockLimit.' type:'.gettype($upperStockLimit));
        // log::debug('lowerStockLimit:'.$lowerStockLimit.' type:'.gettype($lowerStockLimit));
        // log::debug('pressedButton:'.$pressedButton.' type:'.gettype($pressedButton));
        // log::debug('sortToggle:'.$sortToggle.' type:'.gettype($sortToggle));
        return response()->json($selectedProducts);
    }

    /**
     * プロダクト削除
     * @param Illuminate\Http\Request
     * @return json
     */
    public function ajaxDelete(Request $request){
        $id = $request->id;
        $word = $request->word;
        $selectedCompany = $request->company;
        $upperPriceLimit = $request->upperPriceLimit;
        $lowerPriceLimit = $request->lowerPriceLimit;
        $upperStockLimit = $request->upperStockLimit;
        $lowerStockLimit = $request->lowerStockLimit;
        $pressedButton = $request->pressedButton;
        $sortToggle = $request->sortToggle;
        $companies = new Company;
        $products = new Product;
        $allCompany = $companies->getCompanies();
        $product = Product::find($id);

        \DB::beginTransaction();
        try{
            Product::destroy($id);
            \DB::commit();
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }

        // 数が入力がされなかった場合の値を設定
        if(!isset($pressedButton)){
            $pressedButton = 'id';
        }
        if(!isset($upperPriceLimit)){
            $upperPriceLimit = 9999;
        }
        if(!isset($lowerPriceLimit)){
            $lowerPriceLimit = 0;
        }
        if(!isset($upperStockLimit)){
            $upperStockLimit = 9999;
        }
        if(!isset($lowerStockLimit)){
            $lowerStockLimit = 0;
        }
        $upperPriceLimit = (int)$upperPriceLimit;
        $lowerPriceLimit = (int)$lowerPriceLimit;
        $upperStockLimit = (int)$upperStockLimit;
        $lowerStockLimit = (int)$lowerStockLimit;

        if(!isset($word)){
            $word = '%';
        }
        if(!isset($selectedCompany)){
            $selectedCompany = '%';
        }
        // デバッグ用ログ出力
        // log::debug('id:'.$id.' type:'.gettype($id));
        // log::debug('word:'.$word.' type:'.gettype($word));
        // log::debug('selectedCompany:'.$selectedCompany.' type:'.gettype($selectedCompany));
        // log::debug('upperPriceLimit:'.$upperPriceLimit.' type:'.gettype($upperPriceLimit));
        // log::debug('lowerPriceLimit:'.$lowerPriceLimit.' type:'.gettype($lowerPriceLimit));
        // log::debug('upperStockLimit:'.$upperStockLimit.' type:'.gettype($upperStockLimit));
        // log::debug('lowerStockLimit:'.$lowerStockLimit.' type:'.gettype($lowerStockLimit));
        // log::debug('pressedButton:'.$pressedButton.' type:'.gettype($pressedButton));
        // log::debug('sortToggle:'.$sortToggle.' type:'.gettype($sortToggle));
        Storage::delete($product->product_image);
        $selectedProducts = $products->searchProducts($word,$selectedCompany,$upperPriceLimit,$lowerPriceLimit,$upperStockLimit,$lowerStockLimit,$pressedButton,$sortToggle);
        return response()->json($selectedProducts);
    }
}
