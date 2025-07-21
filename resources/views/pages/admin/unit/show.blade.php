@extends('layouts.admin')

@section('title', 'Dashboard')

@push('prepend-style')
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap + DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
@endpush

@section('content')
    <div class="page-heading mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="card-header bg-white border-b border-gray-200 p-4">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Kategori</h2>
                </div>

                <div class="card-body p-6">
                    <!-- 1. Informasi Kategori -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-blue-600 mb-4">1. Kategori</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-700">
                            <div><span class="font-medium">Nama Kategori:</span> {{ $kategori->nama }}</div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-4 border-t border-gray-200 flex flex-col md:flex-row justify-between text-sm text-gray-500">
                        <div class="mb-2 md:mb-0">
                            <p>Dibuat: {{ $kategori->created_at->format('d M Y') }}</p>
                            <p>Diupdate: {{ $kategori->updated_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('kategori.index') }}" class="text-blue-600 hover:underline font-medium">
                                ← Kembali ke daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
    <script>
        // In case you add a table with ID #kategori in future
        new DataTable('#kategori');
    </script>
@endpush
