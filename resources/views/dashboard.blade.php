@extends('master')
@section('title', 'Danh sách phòng')

@section('css')
    <!-- Custom styles for this page -->
    <link href="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    @parent

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phòng trống</h1>
    </div>
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 101</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-hand-peace"></i>
                    </span>
                    <span class="text">Thuê phòng</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 102</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-hand-peace"></i>
                    </span>
                        <span class="text">Thuê phòng</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 103</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-hand-peace"></i>
                    </span>
                        <span class="text">Thuê phòng</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 104</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-hand-peace"></i>
                    </span>
                        <span class="text">Thuê phòng</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phòng đã thuê</h1>
    </div>
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 201</h6>
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
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 202</h6>
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
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 203</h6>
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
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Phòng 204</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-warning btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-cash-register"></i>
                        </span>
                        <span class="text">Trả phòng</span>
                    </a>
                    <div class="my-2"></div>
                    <a href="#" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-money-bill-alt"></i>
                        </span>
                        <span class="text">Thanh toán</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{asset('sb-admin-2/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('sb-admin-2/js/demo/datatables-demo.js')}}"></script>
@endsection

