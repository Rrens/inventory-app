@extends('website.components.master')
@section('title', 'Laporan Pesan Persediaan ' . (!empty($filter_date) ? $filter_date : null))
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Persediaan Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <form id="filter-form" method="get" style="float: right;"
                        class="d-flex justify-content-center align-items-center">
                        <input type="date" class="form-control mr-2" name="date"
                            value="{{ !empty($filter_date) ? $filter_date : null }}" id="dateInput">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        {{-- <a href="#" class="btn btn-primary ml-2 d-flex align-items-center">
                            <span>Print</span>
                            <i class="fa fa-print ml-2"></i>
                        </a> --}}
                    </form>
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
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('laporan.pesan-persediaan.index') }}"
                                    class="btn btn-outline-{{ $value_filter == false ? 'primary' : 'secondary' }} btn-sm">All</a>
                                <a href="{{ route('laporan.pesan-persediaan.filter', 'gudang') }}"
                                    class="btn btn-outline-{{ $value_filter == 'gudang' ? 'primary' : 'secondary' }}  btn-sm"
                                    style="margin: 0 5px;">Gudang</a>
                                <a href="{{ route('laporan.pesan-persediaan.filter', 'toko') }}"
                                    class="btn btn-outline-{{ $value_filter == 'toko' ? 'primary' : 'secondary' }}  btn-sm">Toko</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th>EOQ</th>
                                        <th>ROP</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ format_number($item->stok) }}</td>
                                            <td>{{ format_number($item->eoq) }}</td>
                                            <td>{{ format_number($item->rop) }}</td>
                                            <td>
                                                {{-- <i class="fa fa-circle-xmark icon danger"></i> --}}
                                                @if ($item->stok >= $item->eoq * 2)
                                                    {{-- <i class="fa fa-check icon safe"></i> --}}
                                                    <button class="btn btn-success rounded-pill btn-sm">Aman</button>
                                                    {{-- {!! $logo_verify !!} --}}
                                                @elseif ($item->stok >= $item->eoq + 2)
                                                    {{-- <i class="fa fa-exclamation icon caution"></i> --}}
                                                    <button class="btn btn-warning rounded-pill btn-sm">Ati2</button>
                                                    {{-- {!! $logo_warning !!} --}}
                                                @elseif ($item->stok <= $item->eoq)
                                                    {{-- <i class="fa fa-exclamation-triangle icon danger"></i> --}}
                                                    <button class="btn btn-danger rounded-pill btn-sm">Bahaya</button>
                                                    {{-- {!! $logo_danger !!} --}}
                                                @endif
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

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <style>
        .icon {
            font-size: 2em;
            margin: 10px;
        }

        .safe {
            color: green;
        }

        .caution {
            color: yellow;
        }

        .danger {
            color: red;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
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
@endpush
