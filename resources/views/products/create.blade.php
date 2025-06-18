{{-- resources/views/products/create.blade.php --}}

@extends('layouts.app') {{-- Memperpanjang layout utama aplikasi Anda --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Produk Baru') }}</div> {{-- Judul Card --}}

                <div class="card-body">
                    {{-- Form untuk menyimpan produk baru, POST ke rute products.store --}}
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf {{-- Token CSRF untuk keamanan form Laravel --}}

                        {{-- Input untuk Nama Produk --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nama Produk') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama produk" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Input untuk Harga --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('Harga') }}</label>
                            {{-- type="number" dan step="0.01" disarankan untuk input harga --}}
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Masukkan harga (cth: 100000.00)" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Input untuk Deskripsi Produk --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Deskripsi Produk') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Tulis deskripsi lengkap produk Anda" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Input untuk Gambar Produk --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Gambar Produk (Opsional)') }}</label>
                            {{-- type="file" untuk upload gambar --}}
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Input untuk URL Demo (Opsional) --}}
                        <div class="mb-3">
                            <label for="demo_url" class="form-label">{{ __('URL Demo (Opsional)') }}</label>
                            {{-- type="url" untuk validasi URL dasar oleh browser --}}
                            <input type="url" class="form-control @error('demo_url') is-invalid @enderror" id="demo_url" name="demo_url" placeholder="URL demo produk" value="{{ old('demo_url') }}">
                            @error('demo_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Input untuk Link Google Drive (Opsional) --}}
                        <div class="mb-3">
                            <label for="gdrive_link" class="form-label">{{ __('Link Google Drive (Opsional)') }}</label>
                            {{-- type="url" untuk validasi URL dasar oleh browser --}}
                            <input type="url" class="form-control @error('gdrive_link') is-invalid @enderror" id="gdrive_link" name="gdrive_link" placeholder="Link Google Drive untuk produk" value="{{ old('gdrive_link') }}">
                            @error('gdrive_link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary">{{ __('Simpan Produk') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
