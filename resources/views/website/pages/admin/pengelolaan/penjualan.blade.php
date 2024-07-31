@extends('website.components.master')
@section('title', 'Pesan Barang')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penjualan Barang</h1>
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
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h3 class="card-title">Penjualan Barang</h3>
                            <input class="form-control btn-sm" type="date" style="margin-left: 900px;"
                                value="{{ now()->format('Y-m-d') }}" id="date_1" />
                        </div>
                        <div class="card-body">
                            {{-- <div class="row"> --}}
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ format_number($item->quantity) . ' ' . $item->unit }}</td>
                                            <td>
                                                <button data-toggle="modal" data-target="#modal-choose{{ $item->id }}"
                                                    class="btn btn-outline-dark btn-sm rounded-circle">
                                                    <i class="fa fa-plus-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- </div> --}}
                            <div class="border-top"></div>
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
                                                <th>Quantity</th>
                                                <th>Tanggal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->barang[0]->name }}</td>
                                                    <td>{{ format_number($item->quantity) . ' ' . $item->barang[0]->unit }}
                                                    </td>
                                                    <td>{{ $item->order_date }}</td>
                                                    <td>
                                                        {{-- <button data-toggle="modal"
                                                            data-target="#modal-edit{{ $item->id }}"
                                                            class="btn btn-outline-warning btn-sm">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </button> --}}
                                                        <button data-toggle="modal"
                                                            data-target="#modal-danger{{ $item->id }}"
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

    <input type="number" hidden id="quantity">
    @foreach ($products as $item)
        <div class="modal fade" id="modal-choose{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Simpan Pesanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form action="" method="post"> --}}
                    {{-- @csrf --}}
                    <div class="modal-body">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" onchange="changeQuantity(this)" name="quantity"
                            id="quantity_choose">
                        <input type="date" name="order_date" id="order_date" value="{{ now()->format('Y-m-d') }}"
                            hidden>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" onclick="save({{ $item->id }})" class="btn btn-primary">Simpan</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    @endforeach

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
        <div class="modal fade" id="modal-edit{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Keranjang {{ $item->barang[0]->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('pengelolaan.penjualan.update-cart') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="barang_update_id">Barang</label>
                                        <select name="barang_id" id="barang_id_edit" class="form-control" required>
                                            <option selected hidden>Pilih</option>
                                            @foreach ($products as $row)
                                                <option data-price="{{ $row->price }}" data-stock="{{ $row->quantity }}"
                                                    data-name="{{ $row->name }}"
                                                    {{ old('barang_id') == $row->id ? 'selected' : ($row->id == $item->barang[0]->id ? 'selected' : '') }}
                                                    value="{{ $row->id }}">
                                                    {{ $row->name . ' || (' . $row->quantity . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ empty(old('quantity')) ? $item->quantity : old('quantity') }}"
                                            id="quantity_edit{{ $item->id }}">
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
        <div class="modal fade" id="modal-danger{{ $item->id }}">
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
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        function changeQuantity(value) {
            console.log(value.value)
            $('#quantity').val(value.value)
        }

        $('#date_1').on('change', function() {
            let date = $(this).val();
            // format_date(date)
            $('#order_date').val(date)
            // let order_date = $('#order_date').val('')
            // console.log(order_date)
        })
        $('#order_to').on('change', function() {
            $('#barang_id').prop('disabled', false)
        })

        $('#barang_id').on('change', function() {
            $('#quantity').prop('readonly', false)
        })

        function save(id) {
            // let place = $('#order_to').val()
            let quantity = $('#quantity').val()
            let orderDate = $('#order_date').val()
            let productID = id
            console.log(quantity)
            // let stock = $('#barang_id option:selected').data('stock')

            $.ajax({
                url: `/pengelolaan/penjualan/check-stock/${productID}`,
                method: 'GET',
                success: function(res) {

                    let stock = res
                    if (res === 'data tidak ditemukan') {
                        $('#quantity').val('')
                        // $('#quantity').prop('readonly', true)
                    }

                    $.ajax({
                        url: `/pengelolaan/penjualan/check-safety-stock/${productID}`,
                        method: 'GET',
                        success: function(ss) {
                            let confirmStock = false;
                            let confirmSafetyStock = false;
                            let valueStock = false;

                            let totalCheckResult = stock - quantity;
                            console.log('ss', ss)
                            console.log('stock - quantity = ', totalCheckResult)

                            if (quantity > res) {
                                alert('Quantity melebihi stock!!!')
                                return
                            }


                            if (totalCheckResult <= ss) {
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

                            $.ajax({
                                url: `/pengelolaan/penjualan/check-if-closest-rop-value/${productID}`,
                                method: 'GET',
                                success: (ropValue) => {
                                    console.log(ropValue)
                                    let stockBarang = ropValue['quantity'];
                                    let rop = ropValue['rop'];

                                    // let checkRop = (stockBarang - quantity) - 3;
                                    let checkRop = (stockBarang - quantity);
                                    console.log('check rop', checkRop)
                                    console.log('rop', rop)

                                    // ropValue += 3
                                    // console.log('rop_value')
                                    if (checkRop <= rop) alert(
                                        'Quantity Mendekati ROP')
                                    // // console.log(ropValue)
                                    doSave(valueStock, productID, quantity, orderDate)
                                }
                            })

                            // console.log(valueStock)
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

        function doSave(value_stock, barang_id, quantity, orderDate) {
            // console.log(orderDate)
            $.ajax({
                url: '{{ route('pengelolaan.penjualan.store-cart') }}',
                type: 'POST',
                data: {
                    'status': value_stock,
                    'barang_id': barang_id,
                    'quantity': quantity,
                    'order_date': orderDate,
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

        // function doUpdate(value_stock, barang_id) {
        //     console.log(barang_id)
        //     let id_quantity = `#quantity_edit${barang_id}`
        //     let quantity_edit = $(id_quantity).val('100')
        //     console.log(quantity_edit)
        //     $.ajax({
        //         url: `/pengelolaan/penjualan/check-cart-stock/${barang_id}`,
        //         type: 'GET',
        //         success: function(stock) {
        //             // console.log(stock)
        //             // $.ajax({
        //             //     url: '{{ route('pengelolaan.penjualan.update-cart') }}',
        //             //     type: 'POST',
        //             //     data: {
        //             //         'status': value_stock,
        //             //         'barang_id': barang_id,
        //             //         'quantity': quantity,
        //             //         '_token': '{{ csrf_token() }}',
        //             //     },
        //             //     success: function(res) {
        //             //         console.log(res)
        //             //         if (res == 'sukses') {
        //             //             location.reload();
        //             //         }
        //             //     },
        //             //     error: function(error, xhr) {
        //             //         console.log(error, xhr)
        //             //     }
        //             // })
        //         },
        //         error: function(error, xhr) {
        //             console.log(error, xhr)
        //         }
        //     })

        // }

        $('#barang_id').on('change', function() {
            // let place = $('#order_to').val()
            let productID = $('#barang_id option:selected').val();

            $.ajax({
                url: `/pengelolaan/penjualan/check-stock/${productID}`,
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

        // $('#barang_id_edit').on('change', function() {
        //     $('#quantity_edit').prop('readonly', false)
        // })

        $('#quantity_edit').on('input', function() {
            let productID = $('#barang_id_edit option:selected').val();
            let quantity = $(this).val()

            $.ajax({
                url: `/pengelolaan/penjualan/check-stock/${productID}`,
                method: 'GET',
                success: function(res) {
                    if (quantity > res) {
                        $('#quantity_edit').val(res)
                        alert('Quantity melebihi stock!!!')
                        return
                    }
                },
                error: function(error, xhr) {
                    console.log(error, xhr)
                }
            })
        })
    </script>
@endpush
