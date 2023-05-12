@extends('layouts/main')
@section('content')
    <div class="container">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header">
                    Edit Siswa
                    <a href="/student" type="button" class="btn btn-kembali float-right">Kembali</a>
                </div>
                <form action="/student/edit/{{ $student->nim }}" method="POST" class="m-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input name="old_nim" hidden value="{{ $student->nim }}" />
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nim">NIM <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan NIM" type="text" id="nim" name="nim"
                                class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim', $student->nim) }}">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan Nama" type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $student->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan E-Mail" type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $student->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tambahkan label dan elemen input untuk Foto Lama -->
                        <div class="form-group">
                            <label for="foto_lama">Foto Lama</label>
                            @if ($student->foto)
                                <div><img class="img-fluid" src="{{ asset('storage/' . $student->foto) }}" width="200">
                                </div>
                            @else
                                <p>Tidak ada foto</p>
                            @endif
                        </div>

                        <!-- Tambahkan checkbox untuk menambahkan foto baru -->
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="addFotoBaruCheck">
                                <label class="form-check-label" for="addFotoBaruCheck">
                                    Tambahkan Foto Baru
                                </label>
                            </div>
                        </div>

                        <!-- Tambahkan label dan elemen input untuk Foto Baru -->
                        <div class="form-group" id="fotoBaruGroup" style="display: none;">
                            <label for="foto_baru">Foto Baru</label>
                            <input type="file" id="foto_baru" name="foto_baru"
                                class="form-control @error('foto_baru') is-invalid @enderror">
                            @error('foto_baru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prodi">Prodi <b class="text-danger">*</b></label>
                            <select id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror"
                                required>
                                <option value="">- Pilih Prodi -</option>
                                <option @if (old('prodi', $student->prodi) == 'Teknik Informatika') {{ 'selected' }} @endif>
                                    Teknik Informatika
                                </option>
                                <option @if (old('prodi', $student->prodi) == 'Teknik Rekayasa Keamanan Siber') {{ 'selected' }} @endif>
                                    Teknik Rekayasa Keamanan Siber
                                </option>
                                <option @if (old('prodi', $student->prodi) == 'Teknik Rekayasa Perangkat Lunak') {{ 'selected' }} @endif>
                                    Teknik Rekayasa Perangkat Lunak
                                </option>
                            </select>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/student" class="btn btn-kembali">Batal</a>
                        <button type="reset" class="btn btn-reset">Reset</button>
                        <button type="submit" class="btn btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- (scripts) -->
    <script>
        document.getElementById('addFotoBaruCheck').addEventListener('change', function() {
            const fotoBaruGroup = document.getElementById('fotoBaruGroup');
            if (this.checked) {
                fotoBaruGroup.style.display = 'block';
            } else {
                fotoBaruGroup.style.display = 'none';
            }
        });
    </script>
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

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px 10px 0px 0px;
            padding: 15px;
        }

        .card-header h5 {
            margin-bottom: 0;
        }

        .card-header button {
            margin-left: auto;
        }

        .card-body {
            padding: 0;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn {
            margin: 5px;
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
        }

        /* Warna button Kembali */
        .btn-kembali {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Warna button Simpan */
        .btn-simpan {
            background-color: #28a745;
            border-color: #28a745;
        }

        /* Warna button Reset */
        .btn-reset {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        /* Warna form-control yang tidak valid */
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        /* Pesan error */
        .invalid-feedback {
            display: block;
            margin-top: 5px;
            color: #dc3545;
        }
    </style>
@endsection
