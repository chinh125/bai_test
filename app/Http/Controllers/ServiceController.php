<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show(Service $service){
        $title = "Danh sách sản phẩm & dịch vụ";
        $services = $service::join('products','service.pd_id','=','products.id')->select('service.*','products.name')->get();
        return view('products.index',compact('services','title'));
    }
}
