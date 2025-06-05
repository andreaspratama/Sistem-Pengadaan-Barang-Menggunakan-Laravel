<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ta::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row){
                    $btn = '<a href="' . route('ta.show', $row->id) . '" class="btn btn-sm btn-info me-1">View</a>';
                    $btn .= '<a href="' . route('ta.edit', $row->id) . '" class="btn btn-sm btn-warning me-1">Edit</a>';
                    $btn .= '<form action="' . route('ta.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin hapus?\')">Delete</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        
        return view('pages.admin.ta.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
