<?php

namespace App\Http\Controllers;

use App\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $request->all();
        $list_phong_free = Phong::where('status', '0')
            ->orderBy('name', 'asc');
        $list_phong_rented = Phong::where('status', '1')
            ->orderBy('name', 'asc');
        if (isset($request_data['search'])){
            $list_phong_free = $list_phong_free->where('name', 'like', '%'.$request_data['search'].'%');
            $list_phong_rented = $list_phong_rented->where('name' , 'like', '%'.$request_data['search'].'%');
        }
        $list_phong_free = $list_phong_free->get();
        $list_phong_rented = $list_phong_rented->get();
        return view('dashboard', compact('list_phong_free', 'list_phong_rented'));
    }
}
