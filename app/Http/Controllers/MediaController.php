<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = Media::get();

        return response()->json($media);
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
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswa,mahasiswa_id',
            'kategori_id' => 'required|exists:kategori,kategori_id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'judul_penelitian' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
            'link_media' => 'required|url',
            'gambar_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // cek jika ada eror validasi form
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 422);
        }

        // menyimpan data
        $media = new Media;
        $media->fill($request->all());
        $simpan = $media->save();

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
            'judul' => 'required',
            'id_prodi' => 'required',
            'id_kategori' => 'required',
            'deskripsi' => 'required',
            'file_media' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,7z|max:2048'
        ]);

        // cek jika ada eror validasi form
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 422);
        }

        // cari data berdasarkan id
        $media = Media::find($id);

        // jika data tidak ditemukan
        if (! $media) {
            return response()->json([
                'status' => 'error',
                'error' => 'Data tidak ditemukan'
            ], 422);
        }

        // update data
        $media->fill($request->all());
        $simpan = $media->save();

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
        $media = Media::find($id);
        // jika data tidak ditemukan
        if (! $media) {
            return response()->json([
                'status' => 'error',
                'error' => 'Data tidak ditemukan'
            ], 422);
        }

        $hapus = $media->delete();
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
