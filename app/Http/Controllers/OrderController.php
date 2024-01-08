<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $statuses = Status::all();
        return view('orders.index', compact('orders','statuses'));
    }

    public function create()
    {
        $customers = Customer::all();
        $armadas = Armada::all();
        return view('orders.create', compact('customers', 'armadas'));
    }

    public function store(Request $request)
    {
        $orders = Order::create($request->all());
        $orders->statuses()->attach(1,['tanggal'=>now()]);
        return redirect('/orders')->with('success', 'Order berhasil dibuat');
    }

    public function destroy($id)
    {
        $orders=Order::find($id);
        $orders->delete();
        return redirect('/orders')->with('success','Data Order berhasil dihapus.');
    }

    public function updateStatus(Request $request)
    {
        $orders = Order::find($request->order_id);
        $orders->statuses()->attach($request->status_id,['tanggal'=>$request->tanggal]);
        return redirect('/orders')->with('success', 'Status order berhasil diupdate');
    }

    public function show($id)
    {
        $orders = Order::find($id);
        return view('orders.show', compact('orders'));
    }
}
