@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="gradient-text-secondary mb-1">
            <i class="bi bi-person-circle me-1"></i>
            Profil Saya
        </h4>
        <small class="text-muted">
            Informasi akun Anda
        </small>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row align-items-center mb-4">
                {{-- Foto Profil --}}
                <div class="col-md-3 text-center">
                    @if ($user->foto_profile)
                        <img src="{{ asset('storage/' . $user->foto_profile) }}"
                             class="shadow"
                             width="200"
                             height="200"
                             style="object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center shadow"
                             style="
                                width:200px;
                                height:200px;
                                background:#667eea;
                                color:white;
                                font-size:42px;
                                font-weight:600;
                             ">
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="col-md-9">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="200">Username</th>
                            <td>: {{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>: {{ $user->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Info</th>
                            <td>: {{ $user->info ?? '-' }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('profile.edit') }}"
                       class="btn btn-sm btn-gradient-primary mt-3">
                        <i class="bi bi-pencil-square me-1"></i>
                        Edit Profil
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
