@extends('master')
@section('title', 'Sửa phòng')

@section('css')
@endsection

@section('content')

    @if(!isset($room_detail) || !is_array($room_detail) || empty($room_detail))
        <div class="alert alert-danger" role="alert">
            Phòng này không tồn tại trong hệ thống.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sửa Phòng "{{$room_detail['room_name']}}"</h1>
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
                <form action="{{route('room.update', $room_detail['id'])}}" id="form-create-room" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="room_name">Tên phòng<span class="text-danger"> *</span></label>
                        <input type="text"
                               class="form-control @error('room_name') is-invalid @enderror"
                               id="room_name" name="room_name" placeholder="Nhập tên phòng..."
                               value="{{old('room_name')?old('room_name'):(isset($room_detail['room_name'])?$room_detail['room_name']:'')}}">
                        @error('room_name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="room_floor">Tầng<span class="text-danger"> *</span></label>
                        <select
                            class="form-control @error('room_floor') is-invalid @enderror"
                            id="room_floor" name="room_floor">
                            <option value="0" {{(old('room_floor')?old('room_floor'):isset($room_detail['room_floor'])?$room_detail['room_floor']:'')=='0'?'selected':''}}>Chọn tầng...</option>
                            <option value="1" {{(old('room_floor')?old('room_floor'):isset($room_detail['room_floor'])?$room_detail['room_floor']:'')=='1'?'selected':''}}>Tầng 1</option>
                            <option value="2" {{(old('room_floor')?old('room_floor'):isset($room_detail['room_floor'])?$room_detail['room_floor']:'')=='2'?'selected':''}}>Tầng 2</option>
                            <option value="3" {{(old('room_floor')?old('room_floor'):isset($room_detail['room_floor'])?$room_detail['room_floor']:'')=='3'?'selected':''}}>Tầng 3</option>
                        </select>
                        @error('room_floor')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-create-room">Sửa</button>
                </form>
            </div>
        </div>
    @endif

@endsection

@section('js')
    <script type="text/javascript">
        jQuery('document').ready(function ($) {
           $('#form-create-room').on('submit', function () {
               //Validate
               var room_name = $('#room_name').val();
               var room_floor = $('#room_floor').val();
               var validate = false;
               $('#room_name, #room_floor').removeClass('is-invalid');
               if (room_name.length < 1){
                   validate = true;
                   $('#room_name').addClass('is-invalid');
                   $('#room_name').parents('.form-group').remove('.invalid-feedback');
                   $('#room_name').parents('.form-group').append('<div class="invalid-feedback">Vui lòng nhập tên phòng.</div>');
               }

               if (room_floor <= 0){
                   validate = true;
                   $('#room_floor').addClass('is-invalid');
                   $('#room_floor').parents('.form-group').remove('.invalid-feedback');
                   $('#room_floor').parents('.form-group').append('<div class="invalid-feedback">Vui lòng chọn tầng.</div>');
               }

               if (validate) return false;
           })
        });
    </script>
@endsection

