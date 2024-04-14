@extends('templates.layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0">
            <div class="card-body rounded" style="background: linear-gradient(135deg, rgba(233, 233, 233, 0.5) 0%,rgba(255,255,255,1) 100%);">
                <h3>{{ $title }}</h3>
                <hr>
                <form action="{{ route('product-update',['id'=>request()->route('id')]) }}" method="post" enctype="multipart/form-data" id="productForm">
                    @csrf
                    @foreach ($services as $service)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control" value="{{ $service->name }}" >
                            </div>
                        </div>
                    </div>
                    <div id="serviceSelection">
                        <div class="row service-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_name">Tên dịch vụ</label>
                                    <input type="text" class="form-control service-name" value="{{ $service->service_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Giá</label>
                                    <input type="text" name="price[]" class="form-control price" value="{{ $service->price }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="service_type">Phân loại</label>
                                    <select name="service_type[]" class="form-control type">
                                        <option value="0" {{ $service->service_type == 0 ? 'selected' : '' }}>Thuê xe du lịch</option>
                                        <option value="1" {{ $service->service_type == 1 ? 'selected' : '' }}>Nhà hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description[]">Mô tả</label>
                                
                                    <textarea class="form-control" name="description[]" id="description" rows="3">{{ $service->description }}</textarea>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right ml-2">Submit</button>
                    <a href="{{ route('home') }}" class="btn btn-success float-right">Trang sản phẩm</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
