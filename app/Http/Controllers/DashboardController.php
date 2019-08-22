<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

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
        $list_room_free = Room::whereHas('contracts', function (Builder $query) {
            $query->where('contract_status', '<>', '1');
        })->orWhereDoesntHave('contracts');
        $list_room_rented = Room::whereHas('contracts', function (Builder $query) {
            $query->where('contract_status', '=', '1');
        });
        if (isset($request_data['search'])){
            $list_room_free = $list_room_free->where('room_name', 'like', '%'.$request_data['search'].'%');
            $list_room_rented = $list_room_rented->where('room_name' , 'like', '%'.$request_data['search'].'%');
        }
        $list_room_free = $list_room_free->get()->toArray();
        $list_room_rented = $list_room_rented->get()->toArray();
        return view('dashboard', compact('list_room_free', 'list_room_rented'));
    }

    public function collectMoney(Request $request){
        $request_data = $request->all();
        return view('collect-money');
    }
}
