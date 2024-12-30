<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 5;
        if(strlen($katakunci)){
            $data = produk::where('kode','like',"%$katakunci%")
            ->orWhere('nama','like',"%$katakunci%")
            ->orWhere('harga','like',"%$katakunci%")
            ->paginate($jumlahbaris);
        }else{
            $data = produk::orderBy('kode','desc')->paginate($jumlahbaris);
        }
        return view('produk.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('kode',$request->kode);
        Session::flash('nama',$request->nama);
        Session::flash('harga',$request->harga);

        $request->validate([
            'kode'=>'required|numeric|unique:produk,kode',
            'nama'=>'required|unique:produk,nama',
            'harga'=>'required',
        ],[
            'kode.required'=>'Kode Barang Wajib Diisi!!',
            'kode.numeric'=>'Kode Barang Wajib Dalam Angka!!',
            'kode.unique'=>'Kode Barang Sudah Ada Dalam Database!!',
            'nama.required'=>'Nama Barang Wajib Diisi!!',
            'nama.unique'=>'Nama Barang Sudah Ada Dalam Database!!',
            'harga.required'=>'Harga Barang Wajib Diisi!!',
        ]);
        $data = [
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'harga'=>$request->harga,
        ];
        produk::create($data);
        return redirect()->to('produk')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = produk::where('kode', $id)->first();
        return view('produk.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode'=>'required|numeric',
            'nama'=>'required',
            'harga'=>'required',
        ],[
            'kode.required'=>'Kode Barang Wajib Diisi!!',
            'kode.numeric'=>'Kode Barang Wajib Dalam Angka!!',
            'nama.required'=>'Nama Barang Wajib Diisi!!',
            'harga.required'=>'Harga Barang Wajib Diisi!!',
        ]);
        $data = [
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'harga'=>$request->harga,
        ];
        produk::where('kode', $id)->update($data);
        return redirect()->to('produk')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        produk::where('kode',$id)->delete();
        return redirect()->to('produk')->with('success','Berhasil menghapus data');
    }
}
