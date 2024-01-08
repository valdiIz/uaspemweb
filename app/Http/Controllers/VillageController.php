<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function searchKelurahan(Request $request)
    {
        $villages = Village::where('name','LIKE','%'.$request->search.'%')->get();
        $kelurahan = [];
        foreach($villages as $key => $village){
            $kelurahan[$key]['id'] = $village->id;
            $kelurahan[$key]['text'] = $village->name;
        }
        return response()-> json(['results' => $kelurahan]);
    }
}
