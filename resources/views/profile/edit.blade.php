@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="gradient-text-primary mb-1">
                <i class="bi bi-pencil-square me-1"></i>
                Edit Profil
            </h4>
            <small class="text-muted">
                Perbarui informasi akun Anda
            </small>
        </div>
    </div>

    <form action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- Foto Profil --}}
                <div class="text-center mb-4">
                    @if ($user->foto_profile)
                        <img id="previewImage"
                             src="{{ asset('storage/' . $user->foto_profile) }}"
                             class="shadow"
                             width="200"
                             height="200"
                             style="object-fit: cover;">
                    @else
                        <div id="previewInitial"
                             class="rounded-circle d-flex align-items-center justify-content-center shadow mx-auto"
                             style="
                                width:120px;
                                height:120px;
                                background:#667eea;
                                color:white;
                                font-size:42px;
                                font-weight:600;
                             ">
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        </div>

                        <img id="previewImage"
                             class="rounded-circle shadow d-none"
                             width="120"
                             height="120"
                             style="object-fit: cover;">
                    @endif
                </div>

                {{-- Upload Foto --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Profil</label>
                    <input type="file"
                           name="foto_profile"
                           class="form-control @error('foto_profile') is-invalid @enderror"
                           accept="image/*"
                           onchange="previewFoto(event)">

                    @error('foto_profile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text"
                           name="username"
                           value="{{ old('username', $user->username) }}"
                           class="form-control @error('username') is-invalid @enderror">

                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text"
                           name="nama_lengkap"
                           value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                           class="form-control @error('nama_lengkap') is-invalid @enderror">    
                    @error('nama_pengguna')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Info --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Info</label>
                    <input type="text"  
                           name="info"
                           value="{{ old('info', $user->info) }}"
                           class="form-control @error('info') is-invalid @enderror">  
                    @error('info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Action --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('profile.index') }}"
                       class="btn btn-gradient-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewFoto(event) {
    const image = document.getElementById('previewImage');
    const initial = document.getElementById('previewInitial');

    image.src = URL.createObjectURL(event.target.files[0]);
    image.classList.remove('d-none');

    if (initial) {
        initial.classList.add('d-none');
    }
}
</script>
@endpush
