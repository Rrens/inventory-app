@extends('website.components.master')
@section('title', 'Barang Masuk')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pengelolaan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('pengelolaan.pesan-barang.index') }}" class="btn btn-outline-primary btn-sm"
                                style="float: left;">
                                Pesan Barang
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($data_detail as $item)
                                    {{-- @dd($data->where('id', $item->pemesanan_id)) --}}
                                    @if (
                                        !empty($data->where('id', $item->pemesanan_id)[0]->supplier[0]->name) &&
                                            $data->where('id', $item->pemesanan_id)[0]->status != true)
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-6">Nama Supplier :
                                                                    {{ $data->where('id', $item->pemesanan_id)[0]->supplier[0]->name }}
                                                                </div>
                                                                <div class="col-6">Nama Barang :
                                                                    {{ $item->barang[0]->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-6">Jumlah Pembelian :
                                                                    {{ $item->quantity }} pcs
                                                                </div>
                                                                <div class="col-6">Tempat penyimpanan :
                                                                    {{ $data->where('id', $item->pemesanan_id)[0]->store_for }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer border-top">
                                                    <p class="font-weight-bold" style="float: left;">Rp
                                                        {{ number_format($data->where('id', $item->pemesanan_id)[0]->price_total) }}
                                                    </p>
                                                    <form
                                                        action="{{ route('pengelolaan.barang-masuk.barang_masuk_selesai') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="number" name="id"
                                                            value="{{ $data->where('id', $item->pemesanan_id)[0]->id }}"
                                                            hidden>
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            style="float: right;">Selesai</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
            </div>
    </section>
    </div>
    </div>
    </section>
@endsection

@push('css')
@endpush
@push('script')
@endpush
