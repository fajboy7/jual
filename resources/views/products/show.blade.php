@extends('layouts.app')
@section('content')
    <h1>{{ $product->name }}</h1>
    <div>Deskripsi: {{ $product->description }}</div>
    <div>Harga: Rp{{ number_format($product->price,0,',','.') }}</div>
    @if($product->demo_url)
        <div>Demo: <a href="{{ $product->demo_url }}">{{ $product->demo_url }}</a></div>
    @endif
    @if($product->gdrive_link)
        <div>Link GDrive: <a href="{{ $product->gdrive_link }}">Unduh</a></div>
    @endif
@endsection