@extends('website.components.master')
@section('title', 'Persetujuan Pesan Persediaan')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pesan Persediaan Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Persetujuan</li>
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
                            <h3 class="card-title">Data Pesan Persediaan : {{ $pemesanan_id }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok Sekarang</th>
                                        <th>EOQ</th>
                                        <th>ROP</th>
                                        <th>Jumlah Pemesanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail_penjualan as $item)
                                        <tr>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->jumlah_pemesanan }}</td>
                                            <td>{{ $item->eoq }}</td>
                                            <td>{{ $item->rop }}</td>
                                            <td>{{ $item->jumlah_pemesanan }}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-acc{{ $item->barang_id }}">
                                                    <i class="fa fa-check-circle"></i>
                                                </button>
                                                <button data-toggle="modal"
                                                    data-target="#modal-decline{{ $item->barang_id }}"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fa fa-times-circle"></i>
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

    {{-- @foreach ($data as $item)
        <div class="modal fade" id="modal-acc{{ $item->id }}">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Setuju Pesan Persediaan {{ $item->barang[0]->name }}?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('persetujuan.pesan-persetujuan.action_verif_or_not') }}" method="post">
                        @csrf
                        <div class="modal-footer justify-content-between">
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <input type="text" name="status" value="acc" hidden>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Setuju</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-decline{{ $item->id }}">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tolak Pesan Persediaan {{ $item->barang[0]->name }}?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('persetujuan.pesan-persetujuan.action_verif_or_not') }}" method="post">
                        @csrf
                        <div class="modal-footer justify-content-between">
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
                            <input type="text" name="status" value="decline" hidden>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}


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
