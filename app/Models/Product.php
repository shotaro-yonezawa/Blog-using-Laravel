<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //テーブル名
    protected $table = 'products';

    // 可変項目
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'product_image'
    ];
    
    /**
     * 全てのリストを取得
     * 
     * @return list
     */
    public function getProducts(){
        return DB::table('products')
                ->join('companies','products.company_id','=','companies.id')
                ->select('products.*','companies.company_name')
                ->get();
    }
    
    public function searchProducts($word,$selectedCompany,$upperPriceLimit,$lowerPriceLimit,$upperStockLimit,$lowerStockLimit,$pressedButton,$sortToggle){
        return DB::table('products')
                ->join('companies','products.company_id','=','companies.id')
                ->select('products.*','companies.company_name')
                ->where([
                    ['product_name', 'LIKE', "%$word%"],
                    ['companies.company_name', 'LIKE', "$selectedCompany"],
                    ])
                ->whereBetween('products.price',[$lowerPriceLimit,$upperPriceLimit])
                ->whereBetween('products.stock',[$lowerStockLimit,$upperStockLimit])
                ->orderBy($pressedButton,$sortToggle)
                ->get();
    }

    /**
     * idからリストを取得
     * @param int $id
     * @return list
     */
    public function getProductsById($id){
        return DB::table('products')
                ->join('companies','products.company_id','=','companies.id')
                ->select('products.*','companies.company_name')
                ->where('products.id','=',$id)
                ->first();
    }
}
