@extends('master')
@section('title', 'Dashboard')

@section('css')
    <!-- Custom styles for this page -->
    <link href="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('search')
    <form method="GET" action="" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group form-group">
            <input name="search" value="{{isset($_REQUEST['search'])?$_REQUEST['search']:''}}" type="text" class="form-control bg-light border-0 small" placeholder="Tìm phòng..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
@section('search-mobile')
    <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form method="GET" action="" class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group form-group">
                    <input name="search" value="{{isset($_REQUEST['search'])?$_REQUEST['search']:''}}" type="text" class="form-control bg-light border-0 small" placeholder="Tìm phòng..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>
@endsection
@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phòng trống</h1>
    </div>
    <div class="row">
        @if(isset($list_room_free) && is_array($list_room_free) && !empty($list_room_free))
            @foreach($list_room_free as $room)
                <div class="col-lg-3 mb-4">
                    <div class="card shadow mb-4 border-left-success">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Phòng {{$room['room_name']}}</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{route('room.bookRoom', $room['id'])}}" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-hand-peace"></i>
                                </span>
                                <span class="text">Thuê phòng</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col"><h5>Không có phòng trống</h5></div>
        @endif

    </div>
    <hr/>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phòng đã thuê</h1>
    </div>
    <div class="row">
        @if(isset($list_room_rented) && is_array($list_room_rented) && !empty($list_room_rented))
            @foreach($list_room_rented as $room)
                <div class="col-lg-3 mb-4">
                    <div class="card shadow mb-4 border-left-danger">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Phòng {{$room['room_name']}}</h6>
                        </div>
                        <div class="card-body">
                            <a href="#" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-cash-register"></i>
                                </span>
                                <span class="text">Trả phòng</span>
                            </a>
                            <div class="my-2"></div>
                            <a href="#" class="btn btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-money-bill-alt"></i>
                                </span>
                                <span class="text">Thanh toán</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col"><h5>Không có phòng nào được thuê</h5></div>
        @endif

    </div>
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{asset('sb-admin-2/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('sb-admin-2/js/demo/datatables-demo.js')}}"></script>
@endsection

