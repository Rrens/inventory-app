@extends('website.components.master')
@section('title', 'barang')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="small-box">
                        <div class="inner">
                            <h3>{{ format_number($total_pemesanan) }}</h3>
                            <p>Total Pemesanan</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="small-box">
                        <div class="inner">
                            <h3>{{ format_number($total_barang_masuk) }}</h3>
                            <p>Total Barang Masuk</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="small-box">
                        <div class="inner">
                            <h3>{{ format_number($total_barang_keluar) }}</h3>
                            <p>Total Penjualan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('owner.dashboard.index') }}"
                                    class="btn btn-outline-{{ $value_filter == false ? 'primary' : 'secondary' }} btn-sm">All</a>
                                <a href="{{ route('owner.dashboard.filter', 'gudang') }}"
                                    class="btn btn-outline-{{ $value_filter == 'gudang' ? 'primary' : 'secondary' }}  btn-sm"
                                    style="margin: 0 5px;">Gudang</a>
                                <a href="{{ route('owner.dashboard.filter', 'toko') }}"
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
                                                @if ($item->stok >= $item->eoq * 2)
                                                    {!! $logo_verify !!}
                                                @elseif ($item->stok >= $item->eoq + 2)
                                                    {!! $logo_warning !!}
                                                @elseif ($item->stok <= $item->eoq)
                                                    {!! $logo_danger !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </d>
                </section>
            </div>
        </div>
    </section>
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
@endpush
