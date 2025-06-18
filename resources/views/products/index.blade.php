@extends('layouts.app')
@section('content')
    <h1>Daftar Produk</h1>
    @foreach($products as $product)
        <div>
            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a> - Rp{{ number_format($product->price,0,',','.') }}
        </div>
    @endforeach
    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}">Tambah Produk</a>
        @endif
    @endauth
@endsection