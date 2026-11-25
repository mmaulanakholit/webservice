@extends('masterlayout')

@section('title', 'Home - UTS Pem Web')

@section('content')
    <div class="container">

        <!-- BOOTSTRAP DISMISSING ALERT (Muncul otomatis saat ada pesan sukses) -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tampilkan Error Validasi jika upload gagal -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- BOOTSTRAP GRID CARDS -->
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-1">

            <!-- KARTU 1: TOMBOL TAMBAH (+) MEMBUKA MODAL TAMBAH -->
            <div class="col">
                <div class="card h-100 shadow-sm d-flex justify-content-center align-items-center py-5"
                    style="min-height: 480px;">
                    <button type="button"
                        class="btn btn-success bg-gradient rounded-circle d-flex justify-content-center align-items-center shadow"
                        style="width: 85px; height: 85px;" data-bs-toggle="modal" data-bs-target="#modalTambah"
                        title="Tambah Data">
                        <span class="fs-1 fw-light lh-1">+</span>
                    </button>
                </div>
            </div>

            <!-- LOOPING CARD ANGGOTA DARI DATABASE -->
            @foreach ($biodatas as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top object-fit-cover"
                            height="330" alt="{{ $item->nama }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $item->nama }}</h5>
                            <p class="card-text text-body-secondary">
                                {{ $item->deskripsi }}
                            </p>
                            <div class="mt-auto pt-3 border-top">
                                <!-- Tombol Trigger Modal Edit -->
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                    Edit
                                </button>

                                <!-- Form Hapus -->
                                <form action="{{ route('biodata.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL EDIT UNTUK MASING-MASING CARD -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('biodata.update', $item->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Biodata</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control"
                                            value="{{ $item->nama }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi / Peran</label>
                                        <textarea name="deskripsi" class="form-control" rows="3" required>{{ $item->deskripsi }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ganti Foto (Opsional)</label>
                                        <input type="file" name="foto" class="form-control" accept="image/*">
                                        <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- MODAL TAMBAH CARD BARU -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Anggota Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                placeholder="Contoh: rizki eka prasodjo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi / NIM & Tugas</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Contoh: 12.11.5866 merupakan master dari uts ini..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
