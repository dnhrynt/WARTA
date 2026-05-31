@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 gradient-text-secondary">
                <i class="bi bi-people-fill me-1"></i>
                Manajemen User
            </h4>
            <small class="text-muted">
                Kelola akun pengguna dan hak akses sistem
            </small>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-gradient-secondary">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah User
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->nama_lengkap ?? '-' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.users.update', $user->id) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')

                                        <select name="role"
                                                class="form-select form-select-sm d-inline w-auto"
                                                onchange="this.form.submit()"
                                                {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                                User
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                        {{-- STATUS TEXT --}}
                                        <span class="text-capitalize small text-muted">
                                            {{ $user->status }}
                                        </span>

                                        {{-- TOGGLE STATUS --}}
                                        <form action="{{ route('admin.users.update', $user->id) }}"
                                            method="POST"
                                            class="mb-0">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="role" value="{{ $user->role }}">

                                            <div class="form-check form-switch user-status-switch mb-0">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="status"
                                                    value="active"
                                                    onchange="this.form.submit()"
                                                    {{ $user->status === 'active' ? 'checked' : '' }}
                                                    {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            </div>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                    Data user belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
