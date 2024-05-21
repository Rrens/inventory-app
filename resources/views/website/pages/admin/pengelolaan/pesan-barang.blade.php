@extends('website.components.master')
@section('title', 'Pesan Barang')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pesan Barang</h1>
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
                            <h3 class="card-title">Pesan Barang</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pengelolaan.pesan-barang.store-cart') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="barang_id">Pilih Barang</label>
                                            <select name="barang_id" id="barang_id" class="form-control">
                                                <option selected hidden>Pilih</option>
                                                @foreach ($products as $item)
                                                    <option data-price="{{ $item->price }}" value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="price">Harga per Satuan</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="price" step="0.01"
                                                    min="0" aria-describedby="price" value="{{ old('price') }}"
                                                    name="price" readonly>
                                            </div>
                                            <small id="price" class="form-text text-muted">*Tampilan Harga Sesuai Dengan
                                                data barang</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="quantity">Kuantitas Pembelian</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ old('quantity') }}" id="quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top"></div>
                                <button type="submit" class="btn btn-outline-primary float-right mt-3">Simpan</button>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List Pemesanan</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>EOQ</th>
                                                <th>Jumlah Pemesanan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->barang[0]->name }}</td>
                                                    <td>{{ $item->barang[0]->eoq }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-warning btn-sm" data-toggle="modal"
                                                            data-target="#modal-edit">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </button>
                                                        <button data-toggle="modal" data-target="#modal-delete"
                                                            class="btn btn-outline-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default float-right" data-toggle="modal"
                                        data-target="#modal-save">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-save">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Simpan Pesan Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pengelolaan.pesan-barang.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option selected hidden>Pilih Supplier...</option>
                                        @foreach ($suppliers as $item)
                                            <option {{ old('supplier_id') == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="store_for">Dibeli untuk</label>
                                    <select name="store_for" id="store_for" class="form-control">
                                        <option selected hidden>Pilih tempat</option>
                                        <option value="gudang">Gudang</option>
                                        <option value="toko">Toko</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Tanggal Pesan</label>
                                    <input type="date" name="order_date" class="form-control"
                                        value="{{ !empty(old('order_date')) ? old('order_date') : now()->format('Y-m-d') }}"
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="order_cost">Biaya Pemesanan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" value="{{ old('order_cost') }}"
                                            name="order_cost" id="order_cost">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($cart as $item)
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Barang {{ $item->barang[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pengelolaan.pesan-barang.update-cart') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="barang_update_id">Pilih Barang</label>
                                        <input type="text" class="form-control" value="{{ $item->barang[0]->name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">Harga per Satuan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" id="price_update" step="0.01"
                                                min="0" aria-describedby="price"
                                                value="{{ empty(old('price_update')) ? $item->barang[0]->price : old('price_update') }}"
                                                name="price" readonly>
                                        </div>
                                        <small id="price" class="form-text text-muted">*Tampilan Harga Sesuai Dengan
                                            data barang</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="quantity">Kuantitas Pembelian</label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ empty(old('quantity')) ? $item->quantity : old('quantity') }}"
                                            id="quantity">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($cart as $item)
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Barang {{ $item->barang[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pengelolaan.pesan-barang.delete-cart') }}" method="post">
                        @csrf
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@push('css')
@endpush
@push('script')
    <script>
        $('#barang_id').on('change', function() {
            let price_product = $(this).find(':selected');
            let price = price_product[0].attributes[0].value
            $('#price').val(price)
        })

        $('#barang_update_id').on('change', function() {
            let price_product = $(this).find(':selected');
            let price = price_product[0].attributes[0].value
            $('#price_update').val(price)
        })

        $('#quantity').on('change', function() {
            let quantity = $(this).val()
            let price = $('#price').val()
            let cost = $('#cost').val()
            console.log(quantity)
            console.log(price)
            let total_price = (quantity * price) + parseInt(cost)
            $('#total_price').text('Rp ' + total_price)
        })
    </script>
@endpush
