<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Picture;
use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    public function index() 
    {
        $armadas = Armada::all();
        return view('armadas.index', compact(['armadas']));
    }

    public function create()
    {
        return view('armadas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:5',
            'max_weight'=>'required|numeric',
            'length'=>'required|numeric',
            'width'=>'required|numeric',
            'height'=>'required|numeric',
        ]);
        $armada = Armada::create([
            'name'=>$request->name,
            'max_weight'=>$request->max_weight,
            'length'=>$request->length,
            'width'=>$request->width,
            'height'=>$request->height,
        ]);
        foreach ($request->file('files') as $file) {
            $filename = time().rand(1,200).'.'.$file->extension();
            $file->move(public_path('uploads'),$filename);
            Picture::create([
                'armada_id'=>$armada->id,
                'filename'=>$filename
            ]);
        }
        return redirect('/armadas')->with('success','Data Armada berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $armada = Armada::find($id);
        return view('armadas.edit', compact(['armada']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|min:5',
            'max_weight'=>'required|numeric',
            'length'=>'required|numeric',
            'width'=>'required|numeric',
            'height'=>'required|numeric',
        ]);
        $armada=Armada::find($id);
        $armada->update([
            'name'=>$request->name,
            'max_weight'=>$request->max_weight,
            'length'=>$request->length,
            'width'=>$request->width,
            'height'=>$request->height,
        ]);
        foreach ($request->file('files') as $file) {
            $filename = time().rand(1,200).'.'.$file->extension();
            $file->move(public_path('uploads'),$filename);
            Picture::create([
                'armada_id'=>$armada->id,
                'filename'=>$filename
            ]);
        }
        return redirect('/armadas')->with('success','Data Armada berhasil diubah.');
    }

    public function destroy($id)
    {
        $armada=Armada::find($id);
        $armada->delete();
        return redirect('/armadas')->with('success','Data Armada berhasil dihapus.');
    }
}
