<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Kategori;
use App\Http\Requests\VendorRequest;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Vendor::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', fn($row) => $row->kategori->nama ?? '-')
                ->addColumn('aksi', function($row){
                    $btn = '<a href="' . route('vendor.show', $row->id) . '" class="btn btn-sm btn-info me-1">View</a>';
                    $btn .= '<a href="' . route('vendor.edit', $row->id) . '" class="btn btn-sm btn-warning me-1">Edit</a>';
                    $btn .= '<form action="' . route('vendor.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin hapus?\')">Delete</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        
        return view('pages.admin.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();

        return view('pages.admin.vendor.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Vendor::create($data);

        return redirect()->route('vendor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendor = Vendor::findOrFail($id);

        return view('pages.admin.vendor.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoris = Kategori::all();
        $item = Vendor::findOrFail($id);

        return view('pages.admin.vendor.edit', compact('item', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $item = Vendor::findOrFail($id);
        $data = $request->all();
        $item->update($data);
    
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Vendor::findOrFail($id);
        $item->delete();

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus.');
    }
}
