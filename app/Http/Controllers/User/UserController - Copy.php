<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Mail\VerifikasiEmailUntukRegistrasiPengaduanMasyarakat;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::count();
        $proses = Pengaduan::where('status', 'proses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        return view('home', [
            'pengaduan' => $pengaduan,
            'proses' => $proses,
            'selesai' => $selesai,
        ]);
    }

    // public function tentang()
    // {
    //     return view('pages.user.about');
    // }

    public function pengaduan()
    {
        $pengaduan = Pengaduan::get();
        return view('pages.user.pengaduan', compact('pengaduan'));
    }

    public function masuk()
    {
        return view('pages.user.login');
    }

    public function login(Request $request)
    {

        $data = $request->all();

        $validate = Validator::make($data, [
            'username' => ['required'],
            'password' => ['required']
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {

            $email = Masyarakat::where('email', $request->username)->first();

            if (!$email) {
                return redirect()->back()->with(['pesan' => 'Email tidak terdaftar']);
            }

            $password = Hash::check($request->password, $email->password);


            if (!$password) {
                return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
            }

            if (Auth::guard('masyarakat')->attempt(['email' => $request->username, 'password' => $request->password])) {

                return redirect()->route('pengaduan');
            } else {

                return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
            }
        } else {

            $masyarakat = Masyarakat::where('username', $request->username)->first();

            $petugas = Petugas::where('username', $request->username)->first();

            if ($masyarakat) {
                $username = Masyarakat::where('username', $request->username)->first();

                if (!$username) {
                    return redirect()->back()->with(['pesan' => 'Username tidak terdaftar']);
                }

                $password = Hash::check($request->password, $username->password);

                if (!$password) {
                    return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
                }

                if (Auth::guard('masyarakat')->attempt(['username' => $request->username, 'password' => $request->password])) {

                    return redirect()->route('pengaduan');
                } else {

                    return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
                }
            } elseif ($petugas) {
                $username = Petugas::where('username', $request->username)->first();

                if (!$username) {
                    return redirect()->back()->with(['pesan' => 'Username tidak terdaftar']);
                }

                $password = Hash::check($request->password, $username->password);

                if (!$password) {
                    return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
                }

                if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {

                    return redirect()->route('dashboard');
                } else {

                    return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
                }
            } else {
                return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
            }
        }
    }

    public function register()
    {
        $provinces = Province::all();
        return view('pages.user.register', compact('provinces'));
    }

    public function register_post(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'nik' => ['required', 'min:16', 'max:16'],
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'email', 'string'],
            'telp' => ['required', 'regex:/(08)[0-9]/'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'password'       => ['required', 'string', 'min:6'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        // Konversi nilai dari form ke format yang cocok untuk database
        $jenis_kelamin_singkat = $data['jenis_kelamin'] === 'Laki-laki' ? 'L' : 'P';


        Masyarakat::create([
            'nik' => $data['nik'],
            'name' => $data['name'],
            'username' => strtolower($data['username']),
            'email' => $data['email'],
            'telp' => $data['telp'],
            'jenis_kelamin' => $jenis_kelamin_singkat,
            'password' => Hash::make($data['password']),
        ]);

        $masyarakat = Masyarakat::where('email', $data['email'])->first();

        Auth::guard('masyarakat')->login($masyarakat);

        return redirect('/pengaduan');
    }

    public function logout()
    {
        Auth::guard('masyarakat')->logout();

        return redirect('/login');
    }

    public function storePengaduan(Request $request)
    {

        if (!Auth::guard('masyarakat')->check()) {
            return redirect()->back()->with(['pengaduan' => 'Login dibutuhkan!', 'type' => 'error']);
        }


        $data = $request->all();

        $validate = Validator::make($data, [
            'nama_pelapor' => ['required', 'string'],
            'nama_pelanggar' => ['required', 'string'],
            'kategori_pelanggar' => ['required', 'in:Dosen,Tendik'],
            'isi_laporan' => ['required'],
            'tgl_kejadian' => ['required', 'date'],
            'lokasi_kejadian' => ['required'],
            'foto' => ['nullable', 'image', 'max:2048'], 
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('assets/pengaduan', 'public');
        }

        date_default_timezone_set('Asia/Bangkok');

        $pengaduan = Pengaduan::create([
            'tgl_pengaduan' => date('Y-m-d H:i:s'),
            'nik' => Auth::guard('masyarakat')->user()->nik,
            'nama_pelapor' => $data['nama_pelapor'],
            'nama_pelanggar' => $data['nama_pelanggar'],
            'kategori_pelanggar' => $data['kategori_pelanggar'],
            'isi_laporan' => $data['isi_laporan'],
            'tgl_kejadian' => $data['tgl_kejadian'],
            'lokasi_kejadian' => $data['lokasi_kejadian'],
            'foto' => $data['foto'] ?? 'assets/pengaduan/tambakmekar.png',
            'status' => '0',
        ]);


        if ($pengaduan) {

            return redirect()->back()->with(['pengaduan' => 'Berhasil terkirim!', 'type' => 'success']);
        } else {

            return redirect()->back()->with(['pengaduan' => 'Gagal terkirim!', 'type' => 'error']);
        }
    }

    public function laporan($who = '')
    {
        $terverifikasi = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', '!=', '0']])->get()->count();
        $proses = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', 'proses']])->get()->count();
        $selesai = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', 'selesai']])->get()->count();

        $hitung = [$terverifikasi, $proses, $selesai];

        if ($who == 'saya') {

            $pengaduan = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->orderBy('tgl_pengaduan', 'desc')->get();

            return view('pages.user.laporan', ['pengaduan' => $pengaduan, 'hitung' => $hitung, 'who' => $who]);
        } else {

            $pengaduan = Pengaduan::where('status', '!=', '0')->orderBy('tgl_pengaduan', 'desc')->get();

            return view('pages.user.laporan', ['pengaduan' => $pengaduan, 'hitung' => $hitung, 'who' => $who]);
        }
    }

    public function detailPengaduan($id_pengaduan)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        return view('pages.user.detail', ['pengaduan' => $pengaduan]);
    }

    public function laporanEdit($id_pengaduan)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        return view('user.edit', ['pengaduan' => $pengaduan]);
    }

    public function laporanUpdate(Request $request, $id_pengaduan)
    {
        $data = $request->all();

         $validate = Validator::make($data, [
            'nama_pelapor' => ['required', 'string'],
            'nama_pelanggar' => ['required', 'string'],
            'kategori_pelanggar' => ['required', 'in:Dosen,Tendik'],
            'isi_laporan' => ['required'],
            'tgl_kejadian' => ['required', 'date'],
            'lokasi_kejadian' => ['required'],
            // 'foto' tidak divalidasi karena opsional
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('assets/pengaduan', 'public');
        }

        $pengaduan = Pengaduan::where('id_pengaduan', $id_pengaduan)->first();

        $pengaduan->update([
             'tgl_pengaduan' => date('Y-m-d H:i:s'),
            'nik' => Auth::guard('masyarakat')->user()->nik,
            'nama_pelapor' => $data['nama_pelapor'],
            'nama_pelanggar' => $data['nama_pelanggar'],
            'kategori_pelanggar' => $data['kategori_pelanggar'],
            'isi_laporan' => $data['isi_laporan'],
            'tgl_kejadian' => $data['tgl_kejadian'],
            'lokasi_kejadian' => $data['lokasi_kejadian'],
            'status' => '0',
            'id_kategori' => $data['kategori_kejadian'],
            'foto' => $data['foto'] ?? $pengaduan->foto
        ]);

        return redirect()->route('pekat.detail', $id_pengaduan);
    }

    public function laporanDestroy(Request $request)
    {
        $pengaduan = Pengaduan::where('id_pengaduan', $request->id_pengaduan)->first();

        $pengaduan->delete();

        return 'success';
    }


    public function password()
    {
        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();

        if (Auth::guard('masyarakat')->user()->password == null) {
            $validate = Validator::make($data, [
                'password' => ['required', 'min:6', 'confirmed'],
            ]);
        } else {
            $validate = Validator::make($data, [
                'old_password' => ['required', 'min:6'],
                'password' => ['required', 'min:6', 'confirmed'],
            ]);
        }

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $nik = Auth::guard('masyarakat')->user()->nik;

        $masyarakat = Masyarakat::where('nik', $nik)->first();

        if (Auth::guard('masyarakat')->user()->password == null) {
            $masyarakat->password = Hash::make($data['password']);
            $masyarakat->save();

            return redirect()->back()->with(['pesan' => 'Password berhasil diubah!', 'type' => 'success']);
        } elseif (Hash::check($data['old_password'], $masyarakat->password)) {

            $masyarakat->password = Hash::make($data['password']);
            $masyarakat->save();

            return redirect()->back()->with(['pesan' => 'Password berhasil diubah!', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['pesan' => 'Password lama salah!', 'type' => 'error']);
        }
    }

    public function ubah(Request $request, $what)
    {
        if ($what == 'email') {
            $masyarakat = Masyarakat::where('nik', $request->nik)->first();

            $masyarakat->email = $request->email;
            $masyarakat->save();

            return 'success';
        } elseif ($what == 'telp') {

            $validate = Validator::make($request->all(), [
                'telp' => ['required', 'regex:/(08)[0-9]/'],
            ]);

            if ($validate->fails()) {
                return 'error';
            }

            $masyarakat = Masyarakat::where('nik', $request->nik)->first();

            $masyarakat->telp = $request->telp;
            $masyarakat->save();

            return 'success';
        }
    }

    public function profil()
    {
        $nik = Auth::guard('masyarakat')->user()->nik;

        $masyarakat = Masyarakat::where('nik', $nik)->first();

        return view('user.profil', ['masyarakat' => $masyarakat]);
    }

    public function updateProfil(Request $request)
    {
        $nik = Auth::guard('masyarakat')->user()->nik;

        $data = $request->all();

        $validate = Validator::make($data, [
            'nik' => ['sometimes', 'required', 'min:16', 'max:16', Rule::unique('masyarakat')->ignore($nik, 'nik')],
            'nama' => ['required', 'string'],
            'email' => ['sometimes', 'required', 'email', 'string', Rule::unique('masyarakat')->ignore($nik, 'nik')],
            'username' => ['sometimes', 'required', 'string', 'regex:/^\S*$/u', Rule::unique('masyarakat')->ignore($nik, 'nik'), 'unique:petugas,username'],
            'jenis_kelamin' => ['required'],
            'telp' => ['required', 'regex:/(08)[0-9]/'],
            'alamat' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
            'kode_pos' => ['required'],
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $masyarakat = Masyarakat::where('nik', $nik);

        $masyarakat->update([
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'username' => strtolower($data['username']),
            'jenis_kelamin' => $data['jenis_kelamin'],
            'telp' => $data['telp'],
            'alamat' => $data['alamat'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'kode_pos' => $data['kode_pos'],
            'province_id' => $data['province_id'],
            'regency_id' => $data['regency_id'],
            'district_id' => $data['district_id'],
            'village_id' => $data['village_id'],
        ]);
        return redirect()->back()->with(['pesan' => 'Profil berhasil diubah!', 'type' => 'success']);
    }
}
