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
                            {{-- <form action="{{ route('pengelolaan.barang-keluar.store') }}" method="post"> --}}
                            {{-- @csrf --}}
                            <div class="row">
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
                                        <select name="product" id="product" class="form-control" disabled>
                                            <option selected hidden>Pilih</option>
                                            @foreach ($products as $item)
                                                <option data-price="{{ $item->price }}" data-stock="{{ $item->quantity }}"
                                                    data-name="{{ $item->name }}" value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="quantity">Jumlah Stok keluar</label>
                                        <input type="number" class="form-control" name="quantity" disabled
                                            value="{{ old('quantity') }}" id="quantity">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="date_use">Tanggal digunakan</label>
                                        <input type="date" class="form-control" name="date_use" id="date_use" disabled>
                                    </div>
                                </div>
                            </div>
                            <button id="btn-save" onclick="save()"
                                class="btn btn-outline-primary btn-block">Simpan</button>
                            {{-- </form> --}}
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
        // $('#btn-save').on('click', function() {
        function save() {
            // console.log('oke')
            let quantity = $('#quantity').val()
            let place = $('#order_to').val()
            if (quantity != '') {
                $('#date_use').prop('disabled', false)
            } else {
                $('#date_use').prop('disabled', true)
            }
            let orderDate = $('#date_use').val()

            let productID = $('#product option:selected').val();

            $.ajax({
                url: `/pengelolaan/barang-keluar/check-stock/${productID}/${place}`,
                method: 'GET',
                success: function(res) {
                    if (res === 'data tidak ditemukan') {
                        $('#quantity').val('')
                        $('#product').prop('disabled', true)
                        $('#quantity').prop('disabled', true)
                        $('#date_use').prop('disabled', true)
                        alert('Barang tidak ada')
                    }

                    $.ajax({
                        url: `/pengelolaan/barang-keluar/check-safety-stock/${productID}`,
                        method: 'GET',
                        success: function(ss) {
                            let confirmStock = false;
                            let confirmSafetyStock = false;
                            let valueStock = false;

                            console.log('ss', ss)

                            if (quantity > res) {
                                confirmStock = confirm(
                                    'Quantity melebihi stock, apakah tetap ingin melanjutkan?'
                                );
                                if (confirmStock) {
                                    $('#quantity').val(res);
                                    valueStock = true
                                } else {

                                }
                            } else {
                                confirmStock = true;
                            }

                            if (quantity > ss) {
                                alert('Melebihi Safety Safety Stock')
                                $('#quantity').val(ss);
                                quantity = ss
                            }

                            // console.log(quantity)
                            doSave(valueStock, productID, quantity, orderDate)
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

        function doSave(value_stock, barang_id, quantity, order_date) {
            $.ajax({
                url: '{{ route('pengelolaan.barang-keluar.store') }}',
                type: 'POST',
                data: {
                    'value_stock': value_stock,
                    'barang_id': barang_id,
                    'quantity': quantity,
                    'order_date': order_date,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(res) {
                    console.log(res)
                    location.reload();
                },
                error: function(error, xhr) {
                    console.log(error, xhr)
                }
            })
        }

        // })
    </script>
    <script>
        $('#product').on('change', function() {
            let place = $('#order_to').val()
            let productID = $('#product option:selected').val();

            $.ajax({
                url: `/pengelolaan/barang-keluar/check-stock/${productID}/${place}`,
                method: 'GET',
                success: function(res) {
                    if (res === 'data tidak ditemukan') {
                        $('#quantity').val('')
                        $('#product').prop('disabled', true)
                        $('#quantity').prop('disabled', true)
                        $('#date_use').prop('disabled', true)
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

        $('#order_to').on('change', function() {
            $('#product').prop('disabled', false)
        })

        $('#product').on('change', function() {
            $('#quantity').prop('disabled', false)
        })
    </script>
@endpush
