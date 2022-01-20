<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Company extends Model
{
    //テーブル名
    protected $table = 'companies';

    // 可変項目
    protected $fillable = [
        'company_name',
        'street_address'
    ];

    public function getCompanies(){
        return Company::all();
    }

    
}
