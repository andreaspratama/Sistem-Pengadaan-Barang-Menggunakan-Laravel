<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Unit::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row){
                    $btn = '<a href="' . route('unit.show', $row->id) . '" class="btn btn-sm btn-info me-1">View</a>';
                    $btn .= '<a href="' . route('unit.edit', $row->id) . '" class="btn btn-sm btn-warning me-1">Edit</a>';
                    $btn .= '<form action="' . route('unit.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin hapus?\')">Delete</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        
        return view('pages.admin.unit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Unit::create($data);

        return redirect()->route('unit.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::findOrFail($id);

        return response()->json([
            'nama' => $unit->nama,
            'alamat' => $unit->alamat,
            'no_tlp' => $unit->no_tlp,
            'email' => $unit->email,
            'cp' => $unit->cp,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);

        return view('pages.admin.unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $unit = Unit::findOrFail($id);
        $unit->update($data);

        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('unit.index');
    }
}
