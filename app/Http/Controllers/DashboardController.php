<?php

namespace App\Http\Controllers;

use App\Room;
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
        $list_room_free = Room::where('status', '0')
            ->orderBy('room_name', 'asc');
        $list_room_rented = Room::where('status', '1')
            ->orderBy('room_name', 'asc');
        if (isset($request_data['search'])){
            $list_room_free = $list_room_free->where('room_name', 'like', '%'.$request_data['search'].'%');
            $list_room_rented = $list_room_rented->where('room_name' , 'like', '%'.$request_data['search'].'%');
        }
        $list_room_free = $list_room_free->get()->toArray();
        $list_room_rented = $list_room_rented->get()->toArray();
        return view('dashboard', compact('list_room_free', 'list_room_rented'));
    }
}
