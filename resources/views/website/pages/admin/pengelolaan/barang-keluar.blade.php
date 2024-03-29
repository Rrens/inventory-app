@extends('website.components.master')
@section('title', 'Barang Keluar')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang Keluar</h1>
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
                            <h3 class="card-title">Barang Keluar</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="order_to">Pilih Tempat Penyimpanan</label>
                                            <select name="order_to" id="order_to" class="form-control">
                                                <option selected hidden>Pilih</option>
                                                <option value="toko">toko</option>
                                                <option value="gudang">gudang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="product">Pilih Barang</label>
                                            <select name="product" id="product" class="form-control">
                                                <option selected hidden>Pilih</option>
                                                @foreach ($products as $item)
                                                    <option data-price="{{ $item->price }}" value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="quantity">Jumlah Stok digunakan</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ old('quantity') }}" id="quantity">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="date_use">Tanggal digunakan</label>
                                            <input type="date" class="form-control" name="date_use" id="date_use">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary btn-block">Simpan</button>

                            </form>
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
