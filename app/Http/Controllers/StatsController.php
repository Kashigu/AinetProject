<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:administrar');
    }

    public function index()
    {
        $userCount = User::count();

        $users = User::select('id', 'user_type')->get();

        $userTypeCounts = $users->groupBy('user_type')->map->count();
        $userTypes = $userTypeCounts->keys();

        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
                                ->groupBy('status')
                                ->get();

        return view('stats/index', compact('userCount', 'userTypes', 'userTypeCounts', 'ordersByStatus'));
    }
}
