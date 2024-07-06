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
                            {{-- <form action="{{ route('pengelolaan.penjualan.store-cart') }}" method="post"> --}}
                            {{-- @csrf --}}
                            <div class="row">
                                {{-- @dd(now()->format('d/m/Y')) --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="date_use">Tanggal digunakan</label>
                                        <input type="date" class="form-control" name="date_use" id="date_use"
                                            value="{{ now()->format('Y-m-d') }}" disabled>
                                    </div>
                                </div>
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
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="barang_id">Pilih Barang</label>
                                                <select name="barang_id" id="barang_id" class="form-control" required
                                                    disabled>
                                                    <option selected hidden>Pilih</option>
                                                    @foreach ($products as $item)
                                                        {{-- <option data-price="{{ $item->price }}"
                                                            {{ (empty(old('barang_id')) ? '' : old('barang_id') == $item->id) ? 'selected' : '' }}
                                                            value="{{ $item->id }}">
                                                            {{ $item->name }}
                                                        </option> --}}
                                                        <option data-price="{{ $item->price }}"
                                                            data-stock="{{ $item->quantity }}"
                                                            data-name="{{ $item->name }}"
                                                            {{ (empty(old('barang_id')) ? '' : old('barang_id') == $item->id) ? 'selected' : '' }}
                                                            value="{{ $item->id }}">
                                                            {{ $item->name . ' || (' . $item->quantity . ')' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="price">Quantity</label>
                                                        <input type="number" class="form-control" name="quantity"
                                                            id="quantity" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top"></div>
                            <button id="btn-save" onclick="save()"
                                class="btn btn-outline-primary btn-block">Simpan</button>
                            {{-- </form> --}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h3 class="card-title">List Keranjang</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-head-fixed text-nowrap" id="table-pesan-barang">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Pemesanan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->barang[0]->name }}</td>
                                                    <td>{{ format_number($item->quantity) }}</td>
                                                    <td>
                                                        <button data-toggle="modal"
                                                            data-target="#modal-delete{{ $item->id }}"
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
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
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
                    <h4 class="modal-title">Simpan Pesanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pengelolaan.penjualan.store') }}" method="post">
                    @csrf
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modal-biaya-pemesanan">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Biaya Pemesanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" id="biaya-pemesanan-modal"
                                        placeholder="Masukan biaya pemesanan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- @foreach ($cart as $item)
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}

    @foreach ($cart as $item)
        <div class="modal fade" id="modal-delete{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus {{ $item->barang[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pengelolaan.penjualan.delete-cart') }}" method="post">
                        @csrf
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <button type="submit" class="btn btn-danger">Hapus</button>
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
        $('#order_to').on('change', function() {
            $('#barang_id').prop('disabled', false)
        })

        $('#barang_id').on('change', function() {
            $('#quantity').prop('readonly', false)
        })

        function save() {
            let place = $('#order_to').val()
            let quantity = $('#quantity').val()
            let orderDate = $('#date_use').val()
            let productID = $('#barang_id option:selected').val();
            // console.log(productID)

            $.ajax({
                url: `/pengelolaan/penjualan/check-stock/${productID}/${place}`,
                method: 'GET',
                success: function(res) {
                    // console.log(res)
                    // console.log(productID)
                    if (res === 'data tidak ditemukan') {
                        $('#quantity').val('')
                        // $('#product').prop('disabled', true)
                        $('#quantity').prop('readonly', true)
                        // $('#date_use').prop('disabled', true)
                        // alert('Barang tidak ada')
                        // return
                    }

                    $.ajax({
                        url: `/pengelolaan/penjualan/check-safety-stock/${productID}`,
                        method: 'GET',
                        success: function(ss) {
                            let confirmStock = false;
                            let confirmSafetyStock = false;
                            let valueStock = false;

                            console.log('ss', ss)

                            if (quantity > ss) {
                                confirmSS = confirm(
                                    'Quantity melebihi Safety Stock, apakah tetap ingin melanjutkan?'
                                )

                                if (confirmSS) {
                                    $('#quantity').val(res);
                                    valueStock = true
                                } else {
                                    $('#quantity').val(ss);
                                    quantity = ss
                                    return
                                }

                            }

                            if (quantity > res) {
                                alert('Quantity melebihi stock!!!')
                                return
                            }

                            doSave(valueStock, productID, quantity)

                            // console.log(quantity)
                        },
                        error: function(error, xhr) {
                            console.log(error, xhr)
                        }
                    })
                },
                error: function(error, xhr) {
                    console.log(error, xhr)
                }
            })
        }

        function doSave(value_stock, barang_id, quantity) {
            console.log(value_stock)
            $.ajax({
                url: '{{ route('pengelolaan.penjualan.store-cart') }}',
                type: 'POST',
                data: {
                    'status': value_stock,
                    'barang_id': barang_id,
                    'quantity': quantity,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(res) {
                    console.log(res)
                    if (res == 'sukses') {
                        location.reload();
                    }
                },
                error: function(error, xhr) {
                    console.log(error, xhr)
                }
            })
        }

        $('#barang_id').on('change', function() {
            let place = $('#order_to').val()
            let productID = $('#barang_id option:selected').val();

            $.ajax({
                url: `/pengelolaan/penjualan/check-stock/${productID}/${place}`,
                method: 'GET',
                success: function(res) {
                    console.log(res)
                    if (res === 'data tidak ditemukan') {
                        $('#quantity').val('')
                        $('#barang_id').prop('disabled', true)
                        $('#quantity').prop('readonly', true)
                        alert('Barang tidak ada')
                    } else {
                        $('#date_use').prop('disabled', false)
                    }
                },
                error: function(error, xhr) {
                    console.log(error, xhr)
                }
            })
        })
    </script>
@endpush
