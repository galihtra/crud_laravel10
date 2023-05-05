<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students Add | Laravel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
        }

        .form-control {
            border-radius: 1rem;
        }

        .floatright {
            float: right;
        }

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
    </style>
</head>

<body>
    <div class="container">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Tambah Siswa</h4>
                    <a href="/student" type="button" class="btn btn-outline-light">Kembali</a>
                </div>
                <form action="/student/add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if (session('notifikasi'))
                            <div class="form-group">
                                <div class="alert alert-{{ session('type') }}">
                                    {{ session('notifikasi') }}
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="nim">NIM <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan NIM" type="text" id="nim" name="nim"
                                class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan Nama" type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror" value {{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan E-Mail" type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto <b class="text-danger">*</b></label>
                            <input required placeholder="Upload Foto" type="file"
                                accept="image/png, image/jpg, image/jpeg" id="foto" name="foto"
                                class="form-control">
                            <div class="invalid-feedback" id="fileError" style="display:none;"></div>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Prodi <b class="text-danger">*</b></label>
                            <select required id="prodi" name="prodi"
                                class="form-control @error('prodi') is-invalid @enderror" required>
                                <option value="">- Pilih Prodi -</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Teknik Rekayasa Keamanan Siber">Teknik Rekayasa Keamanan Siber</option>
                                <option value="Teknik Rekayasa Perangkat Lunak">Teknik Rekayasa Perangkat Lunak</option>
                            </select>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <a href="/student" class="btn btn-kembali">Batal</a>
                        <button type="reset" class="btn btn-reset">Reset</button>
                        <button type="submit" id="submitBtn" class="btn btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('foto');
        const fileError = document.getElementById('fileError');
        const submitBtn = document.getElementById('submitBtn');

        fileInput.addEventListener('change', function(e) {
            const allowedExtensions = ['png', 'jpg', 'jpeg'];
            const maxSize = 2 * 1024 * 1024; // 2 MB
            const file = e.target.files[0];
            const fileExt = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExt)) {
                fileError.textContent = 'Hanya format file PNG, JPG, dan JPEG yang diperbolehkan.';
                fileError.style.display = 'block';
                submitBtn.disabled = true;
            } else if (file.size > maxSize) {
                fileError.textContent = 'Ukuran file tidak boleh melebihi 2 MB.';
                fileError.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                fileError.style.display = 'none';
                submitBtn.disabled = false;
            }
        });

        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!submitBtn.disabled) {
                // Proses pengiriman form di sini
                console.log('Form submitted');
                document.querySelector('form').submit();
            }
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-
                         q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-
                         UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-
                         JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

</html>
