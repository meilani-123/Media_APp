<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::get();

        return response()->json($mahasiswa);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi form
        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:mahasiswa,nim',
            'nama_lengkap' => 'required',
            'prodi_id' => 'required|exists:prodi,prodi_id',
        ]);

        // cek jika ada eror validasi form
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 422);
        }

        // menyimpan data
        $mahasiswa = new Mahasiswa;
        $mahasiswa->fill($request->all());
        $simpan = $mahasiswa->save();

        if ($simpan) {
            return response()->json([
                'status' => 'success'
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Gagal menyimpan data'
            ], 422);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // validasi form
        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:mahasiswa,nim,' . $id . ',mahasiswa_id',
            'nama_lengkap' => 'required',
            'prodi_id' => 'required|exists:prodi,prodi_id',
        ]);

        // cek jika ada eror validasi form
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 422);
        }

        // cari data berdasarkan id
        $mahasiswa = Mahasiswa::find($id);

        // jika data tidak ditemukan
        if (! $mahasiswa) {
            return response()->json([
                'status' => 'error',
                'error' => 'Data tidak ditemukan'
            ], 422);
        }

        // update data
        $mahasiswa->fill($request->all());
        $simpan = $mahasiswa->save();

        if ($simpan) {
            return response()->json([
                'status' => 'success'
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Gagal menyimpan data'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cari data berdasarkan id
        $mahasiswa = Mahasiswa::find($id);
        // jika data tidak ditemukan
        if (! $mahasiswa) {
            return response()->json([
                'status' => 'error',
                'error' => 'Data tidak ditemukan'
            ], 422);
        }

        $hapus = $mahasiswa->delete();
        if ($hapus) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Gagal menghapus data data'
            ], 422);
        }
    }
}
