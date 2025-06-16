@extends('layouts.app')

@section('title', 'Hubungi Kami - Lapakku')

@section('content')
<div class="container">
    <div class="card" style="max-width: 700px; margin: 40px auto; padding: 30px;">
        <h1 style="color: #00695C; text-align:center; margin-bottom:25px; font-size:2em;">Hubungi Kami</h1>
        <p style="text-align:center; margin-bottom:30px; color:#555;">
            Punya pertanyaan, saran, atau butuh bantuan? Jangan ragu untuk mengirimkan pesan kepada kami melalui formulir di bawah ini.
        </p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong style="display:block; margin-bottom:5px;">Oops! Ada beberapa masalah dengan input Anda:</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kontak.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap Anda</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', auth()->check() ? auth()->user()->name : '') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email Anda</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required>
            </div>

            {{-- Opsional: Subjek Pesan --}}
            {{--
            <div class="form-group">
                <label for="subjek">Subjek Pesan (Opsional)</label>
                <input type="text" name="subjek" id="subjek" class="form-control" value="{{ old('subjek') }}">
            </div>
            --}}

            <div class="form-group">
                <label for="pesan">Pesan Anda</label>
                <textarea name="pesan" id="pesan" class="form-control" rows="6" required>{{ old('pesan') }}</textarea>
            </div>

            <div class="form-group" style="margin-top:25px;">
                <button type="submit" class="btn btn-primary" style="width:100%; padding:12px; font-size:1.1em;">Kirim Pesan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style dasar untuk form-group dan form-control bisa diambil dari layouts/app.blade.php atau didefinisikan di sini */
    .form-group { margin-bottom: 1.25rem; }
    .form-control {
        display: block;
        width: 100%;
        padding: .5rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 .2rem rgba(0,123,255,.25);
    }
    .alert { margin-bottom: 1.5rem; }
</style>
@endpush
