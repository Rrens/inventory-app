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
                        <li class="breadcrumb-item active">Riwayat</li>
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
                            Riwayat Barang Masuk
                        </div>
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pesan</th>
                                        <th>Nama Barang</th>
                                        <th>Biaya Pesan</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_detail as $item)
                                        {{-- @dd($item, $data, $data->where('id', $item->pemesanan_id)[0]->order_cost) --}}
                                        <tr>
                                            <td>{{ $item->pemesanan[0]->order_date }}</td>
                                            <td>{{ $item->barang[0]->name }}</td>
                                            <td>{{ $item->pemesanan[0]->order_cost }}</td>
                                            </td>
                                            <td>{{ $item->quantity . ' ' . $item->barang[0]->unit }}</td>
                                            <td>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#modal-detail{{ $item->id }}">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    @foreach ($data_detail as $item)
        {{-- @dd($item) --}}
        <div class="modal fade" id="modal-detail{{ $item->id }}">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Setuju Pesan Persediaan?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row border-bottom border-dark">
                            <div class="col-6">
                                <p>Nama Supplier</p>
                                <p>No Telpon</p>
                            </div>
                            <div class="col-6">
                                <p>{{ $item->pemesanan[0]->supplier[0]->name }}</p>
                                <p>{{ $item->pemesanan[0]->supplier[0]->telp }}</p>
                            </div>
                        </div>
                        <div class="row border-dotted mt-3">
                            <div class="col-6">
                                <p>Nama Barang</p>
                                <p>Dibeli Untuk</p>
                                <p>Tanggal Pesan</p>
                                <p>Tanggal Masuk</p>
                            </div>
                            <div class="col-6">
                                <p>{{ $item->barang[0]->name }}</p>
                                <p>{{ $item->pemesanan[0]->store_for }}</p>
                                <p>{{ $item->pemesanan[0]->order_date }}</p>
                                <p>{{ $item->date_in }}</p>
                            </div>
                        </div>
                        <div class="row border-bottom border-dark mt-3">
                            <div class="col-6">
                                <p>Jumlah Pembelian / EOQ</p>
                                <p>Biaya Pemesanan</p>
                                <p>Harga Barang</p>
                            </div>
                            <div class="col-6">
                                <p>{{ $item->quantity . ' ' . $item->barang[0]->unit }}</p>
                                <p>{{ format_rupiah($item->pemesanan[0]->order_cost) }}</p>
                                <p>{{ format_rupiah($item->barang[0]->price) }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <p style="font-weight: bold">Total Harga</p>
                            </div>
                            <div class="col-6">
                                <p>{{ format_rupiah($item->pemesanan[0]->price_total) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .border-dotted {
            border-bottom: 2px dotted #000;
        }
    </style>
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
@endpush
