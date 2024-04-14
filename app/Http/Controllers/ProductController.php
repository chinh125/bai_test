<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function show(Product $pd)
    {
        $title = "Danh sách sản phẩm & dịch vụ";
        $products = $pd::with('services')->get();
        return view('products.index', compact('products', 'title'));
    }


    public function store(Product $pd, Request $request)
    {
        $title = "Thêm sản phẩm & dịch vụ";
        $services = Service::join('products', 'service.pd_id', '=', 'products.id')
            ->select('service.*', 'products.name')
            ->get();
        $products = $pd::with('services')->get();
        $validator = Validator::make(
            [
                'name' => 'required'
            ],
            [
                'name.required' => "Chưa nhập tên sản phẩm",
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages());
        } else {
            if ($request->isMethod('post')) {
                $productData = $request->except('_token');

                $product = Product::create($productData);

                if ($product) {
                    
                    if ($request->has('service_name')) {
                        
                        $selectedServices = $request->input('service_name');
                        $prices = $request->input('price'); 
                        $types = $request->input('service_type'); 
                        $descriptions = $request->input('descriptions'); 

                        foreach ($selectedServices as $index => $serviceId) {
                            $service = new Service();
                            $service->pd_id = $product->id;
                            $service->service_name = $serviceId;
                            $service->price = $prices[$index];
                            $service->service_type = $types[$index]; 
                            $service->description = $descriptions[$index] ?? null; 
                            $service->save();
                        }
                    }

                    Session::flash('success', 'Thêm sản phẩm và dịch vụ thành công');
                } else {
                    Session::flash('error', 'Đã xảy ra lỗi khi thêm sản phẩm');
                }
            }


            return view('products.add', compact('title', 'services', 'products'));
        }
    }

    public function edit($id, Request $request)
{
    $title = "Sửa sản phẩm & dịch vụ";
    
    $services = Service::join('products','service.pd_id','=','products.id')
    ->select('service.*','products.name')
    ->where('service.id', $id)
    ->get();
    
    if ($request->isMethod('post')) {
        
        // $product->update($request->except('_token', 'service_name', 'price', 'service_type', 'descriptions'));
        
        if ($request->has('service_name')) {
            $selectedServices = $request->input('service_name');
            $prices = $request->input('price');
            $types = $request->input('service_type');
            $descriptions = $request->input('descriptions');

            foreach ($selectedServices as $index => $serviceId) {
                $service = Service::where('id', $id)->first();
                    $service->update([
                        'price' => $prices[$index],
                        'service_type' => $types[$index],
                        'description' => $descriptions[$index] ?? null,
                    ]);
            }
        }
    
        Session::flash('success', 'Cập nhật sản phẩm và dịch vụ thành công');
        return redirect()->route('home');
    }

    return view('products.edit', compact( 'services', 'title'));
}

    public function delete($id)
    {
        $result = Service::where('id', $id)->delete();
        return redirect()->route('home');
    }
}
