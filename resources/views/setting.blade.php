@extends('master')
@section('title', 'Cài đặt')

@section('css')
@endsection
@section('search')
@endsection
@section('search-mobile')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cài đặt</h1>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    @if(Session::has('errors-cus'))
        <div class="alert alert-warning" role="alert">
            @if(is_array(Session::get('errors-cus')))
                @foreach(Session::get('errors-cus') as $error)
                    <p>- {{$error}}</p>
                @endforeach
            @else
                {{Session::get('errors-cus')}}
            @endif
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Cài đặt chung</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('app.config.save')}}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="electric_price">Giá điện <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('electric_price') is-invalid @enderror" id="electric_price" name="electric_price"
                               value="{{old('electric_price')?:(strlen(Helpers::getSetting('electric_price'))>0?Helpers::getSetting('electric_price'):'')}}">
                        @error('electric_price')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="water_price">Giá nước <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('water_price') is-invalid @enderror" id="water_price" name="water_price"
                               value="{{old('water_price')?:(strlen(Helpers::getSetting('water_price'))>0?Helpers::getSetting('water_price'):'')}}">
                        @error('water_price')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="trash_price">Giá rác <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('trash_price') is-invalid @enderror" id="trash_price" name="trash_price"
                               value="{{old('trash_price')?:(strlen(Helpers::getSetting('trash_price'))?Helpers::getSetting('trash_price'):'')}}">
                        @error('trash_price')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="room_price_1">Giá phòng Tầng 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('room_price_1') is-invalid @enderror" id="room_price_1" name="room_price_1"
                               value="{{old('room_price_1')?:(strlen(Helpers::getSetting('room_price_1'))?Helpers::getSetting('room_price_1'):'')}}">
                        @error('room_price_1')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="room_price_2">Giá phòng Tầng 2 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('room_price_2') is-invalid @enderror" id="room_price_2" name="room_price_2"
                               value="{{old('room_price_2')?:(strlen(Helpers::getSetting('room_price_2'))?Helpers::getSetting('room_price_2'):'')}}">
                        @error('room_price_2')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="room_price_3">Giá phòng Tầng 3 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('room_price_3') is-invalid @enderror" id="room_price_3" name="room_price_3"
                               value="{{old('room_price_3')?:(strlen(Helpers::getSetting('room_price_3'))?Helpers::getSetting('room_price_3'):'')}}">
                        @error('room_price_3')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="room_101_price">Giá phòng 101 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('room_101_price') is-invalid @enderror" id="room_101_price" name="room_101_price"
                               value="{{old('room_101_price')?:(strlen(Helpers::getSetting('room_101_price'))?Helpers::getSetting('room_101_price'):'')}}">
                        @error('room_101_price')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <small class="form-text text-muted">*Chú ý: Đơn vị giá "nghìn đồng". Ví dụ: 5 : 5000đ </small>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection

