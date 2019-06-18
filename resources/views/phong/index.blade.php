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
        <h1 class="h3 mb-0 text-gray-800">Danh sách phòng</h1>
    </div>
    <div class="card shadow mb-4">
        {{--<div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>--}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Tên Phòng</th>
                        <th>Trạng thái</th>
                        <th>Tầng</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Tên Phòng</th>
                        <th>Trạng thái</th>
                        <th>Tầng</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>Phòng 101</td>
                        <td><i class="fas fa-circle text-success"></i> Còn trống</td>
                        <td>1</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Phòng 102</td>
                        <td><i class="fas fa-circle text-danger"></i> Đã thuê</td>
                        <td>2</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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

