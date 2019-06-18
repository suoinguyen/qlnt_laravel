@extends('master')
@section('title', 'Danh sách phòng')

@section('css')
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tạo Phòng</h1>
    </div>
    <div class="card shadow mb-4">
        {{--<div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tạo Phòng</h6>
        </div>--}}
        <div class="card-body">
            <form action="{{route('room.store')}}" id="form-create-room" method="POST">
                @csrf
                <div class="form-group">
                    <label for="room-name">Tên phòng<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" id="room-name" name="room-name" placeholder="Nhập tên phòng...">
                </div>
                <div class="form-group">
                    <label for="number-of-floor">Tầng<span class="text-danger"> *</span></label>
                    <select class="form-control" id="number-of-floor" name="number-of-floor">
                        <option value="0">Chọn tầng...</option>
                        <option value="1">Tầng 1</option>
                        <option value="2">Tầng 2</option>
                        <option value="3">Tầng 3</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-create-room">Tạo</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery('document').ready(function ($) {
           $('#form-create-room').on('submit', function () {
               //Validate
               var room_name = $('#room-name').val();
               var room_floor = $('#number-of-floor').val();
               var validate = false;
               $('#room-name, #number-of-floor').removeClass('is-invalid');
               if (room_name.length < 1){
                   validate = true;
                   $('#room-name').addClass('is-invalid');
               }

               if (room_floor <= 0){
                   validate = true;
                   $('#number-of-floor').addClass('is-invalid');
               }

               if (validate) return false;
           })
        });
    </script>
@endsection

