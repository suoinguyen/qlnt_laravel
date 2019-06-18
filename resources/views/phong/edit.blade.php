@extends('master')
@section('title', 'Sửa phòng')

@section('css')
@endsection

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sửa Phòng</h1>
    </div>
    @if(Session::has('existed'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('existed')}}
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    @if(Session::has('errors-cus'))
        <div class="alert alert-warning" role="alert">
            {{Session::get('errors-cus')}}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{route('room.update', $phong_detail->id)}}" id="form-create-room" method="POST">
                @csrf
                <div class="form-group">
                    <label for="room-name">Tên phòng<span class="text-danger"> *</span></label>
                    <input type="text"
                           class="form-control @error('room-name') is-invalid @enderror"
                           id="room-name" name="room-name" placeholder="Nhập tên phòng..."
                           value="{{old('room-name')?old('room-name'):(isset($phong_detail->name)?$phong_detail->name:'')}}">
                    @error('room-name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="number-of-floor">Tầng<span class="text-danger"> *</span></label>
                    <select
                        class="form-control @error('number-of-floor') is-invalid @enderror"
                        id="number-of-floor" name="number-of-floor">
                        <option value="0" {{(old('number-of-floor')?old('number-of-floor'):isset($phong_detail->floor)?$phong_detail->floor:'')=='0'?'selected':''}}>Chọn tầng...</option>
                        <option value="1" {{(old('number-of-floor')?old('number-of-floor'):isset($phong_detail->floor)?$phong_detail->floor:'')=='1'?'selected':''}}>Tầng 1</option>
                        <option value="2" {{(old('number-of-floor')?old('number-of-floor'):isset($phong_detail->floor)?$phong_detail->floor:'')=='2'?'selected':''}}>Tầng 2</option>
                        <option value="3" {{(old('number-of-floor')?old('number-of-floor'):isset($phong_detail->floor)?$phong_detail->floor:'')=='3'?'selected':''}}>Tầng 3</option>
                    </select>
                    @error('number-of-floor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-create-room">Sửa</button>
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
                   $('#room-name').parents('.form-group').remove('.invalid-feedback');
                   $('#room-name').parents('.form-group').append('<div class="invalid-feedback">Vui lòng nhập tên phòng.</div>');
               }

               if (room_floor <= 0){
                   validate = true;
                   $('#number-of-floor').addClass('is-invalid');
                   $('#number-of-floor').parents('.form-group').remove('.invalid-feedback');
                   $('#number-of-floor').parents('.form-group').append('<div class="invalid-feedback">Vui lòng chọn tầng.</div>');
               }

               if (validate) return false;
           })
        });
    </script>
@endsection

