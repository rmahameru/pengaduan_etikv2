@extends('layouts.app')

@section('title', 'Pengaduan')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<main id="main" class="martop">

    <section class="inner-page">
      <div class="container ">
        <div class="title text-center mb-5">
            <h3 class="fw-bold">Layanan Pengaduan Etik</h3>
            <h5 class="fw-normal">Sampaikan laporan Anda langsung kepada Direktur Poltekkes Kemenkes Surabaya</h5>
        </div>
       <div class="card card-responsive p-4 border-0 col-md-8 shadow rounded mx-auto">
        <form action="{{ route('pengaduan.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group mb-3">
                <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                <input type="text" value="{{ old('nama_pelapor') }}" name="nama_pelapor" id="nama_pelapor"
                    placeholder="Nama Pelapor" class="form-control @error('nama_pelapor') is-invalid @enderror" required >
                @error('nama_pelapor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
             <div class="form-group mb-3">
                <label for="status_civitas" class="form-label">Status Pelanggar</label>
                <select name="status_civitas" id="status_civitas" class="form-control @error('status_civitas') is-invalid @enderror" required>
                    <option value="" disabled {{ old('status_civitas') ? '' : 'selected' }}>-- Pilih Status --</option>
                    <option value="Dosen" {{ old('status_civitas') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="Tenaga Kependidikan" {{ old('status_civitas') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                    
                </select>
                @error('status_civitas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="nama_pelanggar" class="form-label">Nama Pelanggar</label>
                <input type="text" value="{{ old('nama_pelanggar') }}" name="nama_pelanggar" id="nama_pelanggar"
                    placeholder="Nama Pelanggar" class="form-control @error('nama_pelanggar') is-invalid @enderror" required >
                @error('nama_pelanggar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="kategori_pelanggaran" class="form-label">Kategori Pelanggaran</label>
                <select name="kategori_pelanggaran" id="kategori_pelanggaran" class="form-control @error('kategori_pelanggaran') is-invalid @enderror" required>
                    <option value="" disabled {{ old('kategori_pelanggaran') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                    <option value="Berpakaian tidak sesuai aturan" {{ old('kategori_pelanggaran') == 'Berpakaian tidak sesuai aturan' ? 'selected' : '' }}>Berpakaian tidak sesuai aturan</option>
                    <option value="Perilaku tidak sopan" {{ old('kategori_pelanggaran') == 'Perilaku tidak sopan' ? 'selected' : '' }}>Perilaku tidak sopan</option>
                    <option value="Terlambat" {{ old('kategori_pelanggaran') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="Lainnya" {{ old('kategori_pelanggaran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori_pelanggaran')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="isi_laporan" class="form-label">Isi Laporan</label>
                <textarea name="isi_laporan" id="isi_laporan"
                    placeholder="Silahkan isi Pengaduan" rows="5" class="form-control @error('isi_laporan') is-invalid @enderror" required>{{ old('isi_laporan') }}</textarea>
                @error('isi_laporan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="tgl_kejadian" class="form-label">Tanggal Kejadian</label>
                <input type="date" value="{{ old('tgl_kejadian') }}" name="tgl_kejadian" id="tgl_kejadian"
                    placeholder="Tanggal Kejadian" class="form-control @error('tgl_kejadian') is-invalid @enderror" required
                    >
                @error('tgl_kejadian')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
                <textarea name="lokasi_kejadian" id="lokasi_kejadian"
                    placeholder="Lokasi Kejadian" rows="3" class="form-control @error('lokasi_kejadian') is-invalid @enderror" required>{{ old('lokasi_kejadian') }}</textarea>
                @error('lokasi_kejadian')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="foto" class="form-label">Foto Bukti</label>
                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" required>
                @error('foto')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
       </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection

@push('addon-script')
    <!-- @if (!auth('masyarakat')->check())
        <script>
            Swal.fire({
                title: 'Peringatan!',
                text: "Anda harus login terlebih dahulu!",
                icon: 'warning',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'Masuk',
                allowOutsideClick: false
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('user.masuk') }}';
                }else{
                    window.location.href = '{{ route('user.masuk') }}';
                }
                });
        </script>
    @elseif(auth('masyarakat')->user()->email_verified_at == null && auth('masyarakat')->user()->telp_verified_at == null)
        <script>
            Swal.fire({
                title: 'Peringatan!',
                text: "Akun belum diverifikasi!",
                icon: 'warning',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'Ok',
                allowOutsideClick: false
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('user.masuk') }}';
                }else{
                    window.location.href = '{{ route('user.masuk') }}';
                }
                });
        </script>
    @endif -->

    @if (session()->has('pengaduan'))
        <script>
            Swal.fire({
                title: 'Pemberitahuan!',
                text: '{{ session()->get('pengaduan') }}',
                icon: '{{ session()->get('type') }}',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'OK',
            });
        </script>
    @endif
@endpush
