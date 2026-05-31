@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="mb-1 gradient-text-secondary">
                <i class="bi bi-person-plus-fill me-1"></i>
                Tambah User
            </h4>
            <small class="text-muted">
                Buat akun pengguna baru dan tentukan hak aksesnya
            </small>
        </div>

    </div>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-1"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- USERNAME --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               value="{{ old('username') }}"
                               class="form-control @error('username') is-invalid @enderror"
                               placeholder="Masukkan username"
                               required>

                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Password <span class="text-danger">*</span>
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 6 karakter"
                               required>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ROLE --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Role <span class="text-danger">*</span>
                        </label>
                        <select name="role"
                                class="form-select @error('role') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                                User
                            </option>
                        </select>

                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- ACTION --}}
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-gradient-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
