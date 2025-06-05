<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formvendor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FormvendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Formvendor::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row){
                    $btn = '<a href="' . route('formvendor.show', $row->id) . '" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill px-2"></i>View</a>';
                    $btn .= '<a href="' . route('formvendor.edit', $row->id) . '" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square px-2"></i>Edit</a>';
                    $btn .= '<form action="' . route('formvendor.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin hapus?\')"><i class="bi bi-trash3-fill px-2"></i>Delete</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        
        return view('pages.admin.formvendor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.formvendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Formvendor::create($data);

        return redirect()->route('formvendor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendor = Formvendor::findOrFail($id);

        return view('pages.admin.formvendor.show', compact('vendor'));
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
