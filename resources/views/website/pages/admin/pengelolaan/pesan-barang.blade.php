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
                            <form action="" method="post">
                                <div class="row">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nama Supplier</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" id="name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="order_to">Dibeli Untuk</label>
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
                                            <label for="cost">Biaya Pemesanan</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="number" class="form-control" id="cost"
                                                    value="{{ old('cost') }}" name="cost">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="price">Harga per Satuan</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control" id="price"
                                                    aria-describedby="price" value="{{ old('price') }}" name="price"
                                                    readonly>
                                            </div>
                                            <small id="price" class="form-text text-muted">*Tampilan Harga Sesuai Dengan
                                                data barang</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="quantity">Kuantitas Pembelian</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ old('quantity') }}" id="quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top"></div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-start">
                                        <p>Total Harga</p>
                                        <p id="total_price">Rp 0</p>
                                    </div>
                                    <div class="flex-end">
                                        <button class="btn btn-outline-primary">Simpan</button>
                                    </div>
                                </div>
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
    <script>
        $('#product').on('change', function() {
            let price_product = $(this).find(':selected');
            let price = price_product[0].attributes[0].value
            $('#price').val(price)
        })

        $('#quantity').on('change', function() {
            let quantity = $(this).val()
            let price = $('#price').val()
            let total_price = quantity * price
            $('#total_price').text('Rp ' + total_price)
        })
    </script>
@endpush
