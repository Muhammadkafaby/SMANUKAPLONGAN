<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Jurusan::OrderBy('nama_jurusan', 'asc')->get();
        $mapel = Mapel::OrderBy('nama_mapel', 'asc')->get();

        return view('pages.admin.mapel.index', compact('mapel', 'jurusan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_mapel' => 'required|unique:mapels',
            'jurusan_id' => 'required'
        ], [
            'nama_mapel.unique' => 'Nama Mapel sudah ada',
        ]);

        Mapel::updateOrCreate(
            [
                'id' => $request->mapel_id
            ],
            [
                'nama_mapel' => $request->nama_mapel,
                'jurusan_id' => $request->jurusan_id,
            ]
        );

        return back()->with('success', 'Data mapel berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = Mapel::findOrFail($id);

        return view('pages.admin.mapel.edit', compact('mapel'));
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
        $data = $request->all();
        $mapel = Mapel::findOrFail($id);
        $mapel->update($data);

        return redirect()->route('mapel.index')->with('success', 'Data mapel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mapel::find($id)->delete();
        return back()->with('success', 'Data mapel berhasil dihapus!');
    }
}
