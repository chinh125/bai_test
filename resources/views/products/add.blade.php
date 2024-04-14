@extends('templates.layout')
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card border-0">
        <div class="card-body rounded" style="background: linear-gradient(135deg, rgba(211,211,211,0.5) 0%,rgba(255,255,255,1) 100%);">
          <h3>{{ $title }}</h3>
          <hr>
          <form action="{{ route('product-add') }}" method="post" enctype="multipart/form-data" id="productForm">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Tên sản phẩm</label>
                  <select name="name" id="" class="form-control">
                    <option value=""></option>
                    @foreach($products as $product)
                      <option value="{{ $product->name }}">{{ $product->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div id="serviceSelection">
              <div class="row service-row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="service_name">Tên dịch vụ</label>
                    <select name="service_name[]" class="form-control service-name">
                      <option value=""></option>
                      @foreach ($services as $service)
                      <option value="{{ $service->service_name }}">{{ $service->service_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="text" name="price[]" class="form-control price">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="service_type">Phân loại</label>
                    <select name="service_type[]" class="form-control type">
                      <option value=""></option>
                      <option value="0">Thuê xe du lịch</option>
                      <option value="1">Nhà hàng</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="addService">Thêm dịch vụ</button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description[]">Mô tả</label>
                  <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('addService').addEventListener('click', function () {
        var serviceSelection = document.getElementById('serviceSelection');
        var newServiceRow = document.createElement('div');
        newServiceRow.classList.add('row', 'service-row');
        newServiceRow.innerHTML = `
          <div class="col-md-6">
            <div class="form-group">
              <label for="service_name">Tên dịch vụ</label>
              <select name="service_name[]" class="form-control service-name">
                @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="price">Giá</label>
              <input type="text" name="price[]" class="form-control price">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="type">Phân loại</label>
              <select name="type[]" class="form-control type">
                <option value=""></option>
                <option value="0">Thuê xe du lịch</option>
                <option value="1">Nhà hàng</option>
              </select>
            </div>
          </div>
        `;
        serviceSelection.appendChild(newServiceRow);
      });
    });
  </script>
@endsection
