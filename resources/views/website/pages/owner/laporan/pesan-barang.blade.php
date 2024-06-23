@extends('website.components.master')
@section('title', 'Laporan Pesan Persediaan')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Pesan Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
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
                            <h3 class="card-title">Data Laporan Pesan Barang</h3>
                            <form id="filter-form" method="get" style="float: right;"
                                class="d-flex justify-content-center align-items-center">
                                <input type="date" class="form-control mr-2" name="date"
                                    value="{{ !empty($value_filter) ? $value_filter : null }}" id="dateInput">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                {{-- <a href="#" class="btn btn-primary ml-2 d-flex align-items-center">
                                    <span>Print</span>
                                    <i class="fa fa-print ml-2"></i>
                                </a> --}}
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Supplier</th>
                                        <th>Nama Barang</th>
                                        <th>Tgl Pesan</th>
                                        <th>Biaya Pemesanan</th>
                                        <th>Harga</th>
                                        <th>Jumlah Pesanan (satuan)</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->supplier[0]->name }}</td>
                                            <td>{{ $item->barang[0]->name }}</td>
                                            <td>{{ $item->pemesanan[0]->order_date }}</td>
                                            <td>{{ format_rupiah($item->pemesanan[0]->order_cost) }}</td>
                                            <td>{{ format_rupiah($item->barang[0]->price) }}</td>
                                            <td>{{ format_number($item->quantity) . ' ' . $item->barang[0]->unit }}</td>
                                            <td>{{ format_rupiah($item->pemesanan[0]->price_total) }}</td>
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

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script> --}}
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
        $('#filter-form').on('submit', function(event) {
            event.preventDefault();
            let dateValue = $('#dateInput').val();

            if (dateValue) {
                let actionUrl = `{{ env('BASE_URL') }}/laporan/pesan-barang/${dateValue}`
                window.location.href = actionUrl;
            } else {
                alert('Please select a date');
            }
        });
    </script>
@endpush
