@extends('layouts/main')

@section('content')
    <div <!-- Judul Halaman -->
        <h1>Manajemen Data Siswa Menggunakan Laravel</h1>

        <!-- Deskripsi Halaman -->
        <p>Halaman ini menampilkan daftar siswa yang terdaftar dalam sistem. Anda dapat menambahkan, mengedit, atau
            menghapus data siswa menggunakan tombol aksi di sebelah kanan tabel.</p>

        <div class="card">
            <div class="card-header">
                <div>Data Siswa</div>
                <a href="/student/add" type="button" class="btn btn-tambah text-white">Tambah</a>
            </div>
            <div class="card-body">
                @if (session('notifikasi'))
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('notifikasi') }}
                    </div>
                @endif
                <div class="table-responsive p-3">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Prodi</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->nim }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->prodi }}</td>
                                    <td class="photo"><img class="img-fluid" src="{{ asset('storage/' . $data->foto) }}">
                                    </td>

                                    <td class="d-flex justify-content-lg-start">
                                        <a href="/student/edit/{{ $data->nim }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="/student/delete/{{ $data->nim }}"
                                            onsubmit="return confirm('Anda yakin ingin menghapus data siswa ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        <!-- Tambahkan tombol Preview dan Download -->
                                        <button type="button" class="btn btn-info"
                                            onclick="window.open('{{ asset('storage/' . $data->foto) }}', '_blank')">Preview</button>
                                        <a href="{{ asset('storage/' . $data->foto) }}" class="btn btn-primary"
                                            download>Download</a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Tidak ada data untuk ditampilkan!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection


    @section('styles')
        <style>
            /* CSS styling for the page */
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f8f8;
            }

            .container {
                margin-top: 20px;
            }

            .card-header {
                background-color: #007bff;
                color: #fff;
                font-weight: bold;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .card-header button {
                margin-left: auto;
            }

            .card-body {
                padding: 0;
            }

            /* Warna button tambah */
            .btn-tambah {
                background-color: #28a745;
                border-color: #28a745;

            }

            table {
                width: 100%;
            }

            th {
                background-color: #007bff;
                color: #0000000;
                font-weight: bold;
                text-align: center;
                vertical-align: middle;
            }

            td {
                text-align: center;
                vertical-align: middle;
            }

            .table tbody tr:hover {
                background-color: #f2f2f2;
            }

            .table .photo {
                max-width: 100px;
            }

            .btn {
                margin: 5px;
            }
        </style>
    @endsection
