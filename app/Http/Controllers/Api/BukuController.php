<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Buku::orderBy('judul', 'asc')->paginate(10);
        return response()->json([
            'status' => true,
            'messege' => 'data ditemukan',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Buku;

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'messege' => 'gagal memasukan data',
                'data' => $validator->errors()
            ]);
        }

        $data->judul = $request->judul;
        $data->pengarang = $request->pengarang;
        $data->tanggal_publikasi = $request->tanggal_publikasi;

        $simpan = $data->save();
        return response()->json([
            'status' => true,
            'messege' => 'data berhasil di tambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Buku::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'messege' => 'data ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'messege' => 'data  Tidak ditemukan',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Buku::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => true,
                'messege' => 'data tidak di temukan'
            ], 404);
        }

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'messege' => 'update gagal',
                'data' => $validator->errors()
            ]);
        }

        $data->judul = $request->judul;
        $data->pengarang = $request->pengarang;
        $data->tanggal_publikasi = $request->tanggal_publikasi;

        $simpan = $data->save();
        return response()->json([
            'messege' => 'update berhasil',
            "data" => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Buku::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => true,
                'messege' => 'data tidak di temukan'
            ], 404);
        }
        $simpan = $data->delete();
        return response()->json([
            'messege' => 'berhasil',
            "data" => $data
        ]);
    }
}
