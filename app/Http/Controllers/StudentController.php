<?php

namespace App\Http\Controllers;


use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = Student::all();
        return view('student.index', ['students' => $students]);
    }

    public function create()
    {
        return view('student.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
            'foto' => 'required'
        ], [
                'nim.required' => 'NIM harus diisi.',
                'nim.unique' => 'NIM sudah digunakan.',
                'nama.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'prodi.required' => 'Program studi harus diisi.',

                'foto.required' => 'Foto harus diupload.'
            ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('public/foto');
            $foto = basename($foto);
        } else {
            $foto = null;
        }

        $students = new Student($validatedData);
        $students->nim = $request->nim;
        $students->nama = $request->nama;
        $students->email = $request->email;
        $students->prodi = $request->prodi;

        $students->foto = $foto ? 'foto/' . $foto : null;

        if ($students->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil disimpan !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->
                with([
                    'notifikasi' => 'Data gagal disimpan !',
                    'type' => 'error'
                ]);
        }
    }

    public function edit(string $id)
    {
        $student = Student::where(['nim' => $id]);
        if ($student->count() < 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }
        return view('student.edit', ['student' => $student->first()]);
    }

    public function update(Request $request, string $id)
{
    // ddd($request->old_nim, $request->nim);
    // Tambahkan validasi untuk foto_baru
    $validatedData = $request->validate([
        'nim' => [
            'required',
            'unique:students,nim,' . $request->old_nim . ',nim',
        ],
        'nama' => 'required',
        'email' => 'required|email',
        'prodi' => 'required',
        'foto_baru' => 'nullable|image|max:2048'
    ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
            'foto_baru.mimes' => 'Format gambar yang diizinkan: JPEG, JPG, PNG.',
            'foto_baru' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);
    $student = Student::where('nim', $id)->first();
    $student->nim = $request->nim;
    $student->nama = $request->nama;
    $student->email = $request->email;
    $student->prodi = $request->prodi;

    // Tambahkan logika untuk menggantikan foto lama jika ada foto baru yang diunggah
    if ($request->hasFile('foto_baru')) {
        $fotoBaru = $request->file('foto_baru');
        $fotoBaruNama = time() . '_' . $fotoBaru->getClientOriginalName();
        $fotoBaru->move(public_path('storage/foto'), $fotoBaruNama);

        // Hapus foto lama jika ada
        $fotoLama = $student->foto;
        if ($fotoLama) {
            $fotoLamaPath = public_path('storage/' . $fotoLama);
            if (file_exists($fotoLamaPath)) {
                unlink($fotoLamaPath);
            }
        }

        // Perbarui atribut foto pada model
        $student->foto = 'foto/' . $fotoBaruNama;
    }

    if ($student->save()) {
        return redirect('/student')->with([
            'notifikasi' => 'Data Berhasil diedit !',
            'type' => 'success'
        ]);
    } else {
        return redirect()->back()->with([
            'notifikasi' => 'Data gagal diedit !',
            'type' => 'error'
        ]);
    }
}


    public function destroy(string $id)
    {
        $student = Student::where(['nim' => $id])->firstOrFail();

        $foto_siswa = $student->foto;

        if ($student->delete()) {

            if (empty($foto_siswa) && Storage::exists($foto_siswa)) {
                Storage::delete($foto_siswa);
            }
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tsidak ditemukan !',
                'type' => 'error'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal dihapus !',
                'type' => 'error'
            ]);
        }
    }

}