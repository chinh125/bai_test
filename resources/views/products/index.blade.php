@extends('templates.layout')
@section('content')
  <style>
    .toggle-task-options {
        width: 30px; /* Chiều rộng của ô vuông */
        height: 30px; /* Chiều cao của ô vuông */
        display: flex; /* Sử dụng flexbox */
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center; /* Căn giữa theo chiều dọc */
        background-color: #eef1f8; /* Màu nền */
        color: #d8dff1; /* Màu chữ */
        border: none; /* Loại bỏ đường viền */
        border-radius: 5px; /* Bo tròn góc */
        cursor: pointer; /* Con trỏ chuột */
        transition: background-color 0.3s; /* Hiệu ứng chuyển đổi màu nền */
    }

    .toggle-task-options:hover {
        background-color: #2980b9; /* Màu nền khi di chuột qua */
    }
    .success{
        border: 1px green solid;
        border-radius: 10px;
        font-size: 12px;
        background-color: rgb(69, 172, 69);
        color: #fff;
        display: flex; /* Sử dụng flexbox */
        justify-content: center; /* Căn giữa theo chiều ngang */
        align-items: center; /* Căn giữa theo chiều dọc */
        margin-top: 10px;
        width: 70px;
    }
    .table-container {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    background-color: rgba(0, 0, 0, 0.1); /* Màu nền xám nhạt */
}

.blur-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* backdrop-filter: blur(10px); Hiệu ứng làm mờ */
}

.table {
    position: relative;
    z-index: 1;
}

</style>
<div class="table-container">
    <div class="row" style="margin-bottom: 10px;margin-top:10px">
            <div class="col-md-8" style="font-size: 20px;margin-top:5px"> <h5>{{ $title }}</h5> </div>
            <div class="col-md-4 d-flex justify-content-end">
                <a href="{{ route('product-add') }}" class="btn" style="background-color:#00bae0;color: #FFF">Thêm sản phẩm</a>
            </div>
    </div>

    <table class="table">
        <thead>
            <tr class="table-info">
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Tên dịch vụ</th>
                <th scope="col">Phân loại</th>
                <th scope="col">Đơn giá</th>
                <th scope="col">Mô tả</th>
                <th style="width: 100px" scope="col">Trạng thái</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                @php $firstService = true; @endphp <!-- Biến đánh dấu dịch vụ đầu tiên của mỗi sản phẩm -->
                @foreach ($product->services as $service)
                    <tr>
                        <!-- Chỉ hiển thị tên sản phẩm ở hàng đầu tiên -->
                        @if ($firstService)
                            <td rowspan="{{ count($product->services) }}">{{ $product->name }}</td>
                            @php $firstService = false; @endphp <!-- Đánh dấu đã hiển thị tên sản phẩm -->
                        @endif
                        <!-- Hiển thị thông tin dịch vụ -->
                        <td style="width:250px">{{ $service->service_name }}</td>
                        <td>{{ $service->service_type == 0 ? "Thuê xe du lịch " : "Nhà hàng" }}</td>
                        <td style="color: red">{{ number_format($service->price, 0, '.') }}</td>
                        <td>{{ $service->description }}</td>
                        <!-- Thêm các cột khác tùy theo cần thiết -->
                        <td><div class="success">Kích hoạt</div></td> 
                        <td class="task-options" style="display: none;">
                            <!-- Các nút thêm, sửa, xóa -->
                            <a href="{{ route('product-update', ['id' => $service->id]) }}" class="btn btn-primary">Sửa</a>

                            <a href="{{ route('delete',['id'=>$service->id]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                        <td>
                            <button class="toggle-task-options">...</button>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
    <script>
        document.querySelectorAll('.toggle-task-options').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var row = this.closest('tr');
                var taskOptions = row.querySelector('.task-options');
                taskOptions.style.display = taskOptions.style.display === 'none' ? 'table-cell' : 'none';
    
                // Ẩn đi các nút thêm, sửa, xóa khi ẩn phần tác vụ
                if (taskOptions.style.display === 'none') {
                    row.querySelectorAll('.task-options button').forEach(function(button) {
                        button.style.display = 'none';
                    });
                }
            });
        });
    </script>
@endsection