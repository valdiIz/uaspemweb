<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        $armadas = Armada::all();
        return view('web.home', compact('armadas'));
    }

    public function store(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();
        if(!$customer){
            $customer = Customer::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'address'=> $request->address,
                'phone'=> $request->phone,
            ]);
        }
        $request->request->add(['customer_id'=>$customer->id]);
        $order = Order::create($request-> except(['name','email','address','phone']));
        $order->statuses()->attach(1,['tanggal'=>now()]);
        return redirect()->back()->with('success', 'Order berhasil dibuat');
    }

    public function tracking()
    {
        return view('web.tracking');
    }

    public function postTracking(Request $request)
    {
        $request->validate([
            'no_resi' => 'required',
            'phone' => 'required|min_digits:4|max_digits:4'
        ]);

        $dataResi = explode('-',$request->no_resi);
        if($dataResi[0] != env("RESI_PREFIX")){
            return redirect()->back()->withInput()->with('error','Resi Tidak Valid');
        }

        $order = Order::find($dataResi[1]);
        if(!$order){
            return redirect()->back()->withInput()->with('error','Resi Tidak Valid');
        }
        
        if($dataResi[2] != $order->waktu_muat->format('dmY')){
            return redirect()->back()->withInput()->with('error','Resi Tidak Valid');
        }
        return view('web.post-tracking', compact('order'));
    }
}
