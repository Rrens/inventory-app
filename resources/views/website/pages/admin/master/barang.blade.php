@extends('website.components.master')
@section('title', 'barang')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Barang</li>
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
                            <h3 class="card-title">Data Barang</h3>
                            <button type="button" class="btn btn-outline-primary btn-sm" style="float: right;"
                                data-toggle="modal" data-target="#modal-add">
                                <i class="fa fa-plus-square "></i>
                                Tambah Barang
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang (satuan)</th>
                                        <th>Harga Barang</th>
                                        <th>Biaya Simpan</th>
                                        <th>Tempat Barang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- LOOPING DATA --}}
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ format_rupiah($item->price) }}</td>
                                            <td>{{ format_rupiah($item->saving_cost) }}</td>
                                            <td>{{ $item->place }}</td>
                                            <td>
                                                <button class="btn btn-outline-warning btn-sm" data-toggle="modal"
                                                    data-target="#modal-edit{{ $item->id }}">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>
                                                <button data-toggle="modal" data-target="#modal-delete{{ $item->id }}"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button data-toggle="modal" data-target="#modal-detail{{ $item->id }}"
                                                    class="btn btn-outline-info btn-sm">
                                                    <i class="fa fa-glasses"></i>
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

    <div class="modal fade" id="modal-add">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('master.barang.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="id_barang">ID Barang</label>
                                    <input type="text" class="form-control" name="id_barang" value="{{ $id_barang }}"
                                        id="id_barang" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nama Barang</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        id="name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="leadtime">Lead Time</label>
                                    <input type="text" class="form-control" name="leadtime"
                                        value="{{ old('leadtime') }}" id="leadtime">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="place">Tempat Barang</label>
                                    <select name="place" id="place" class="form-control">
                                        <option selected hidden>Pilih Tempat</option>
                                        <option {{ old('place') == 'gudang' ? 'selected' : '' }} value="gudang">Gudang
                                        </option>
                                        <option {{ old('place') == 'toko' ? 'selected' : '' }} value="toko">Toko
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="saving_cost">Biaya Simpan Barang</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" id="saving_cost"
                                            value="{{ old('saving_cost') }}" name="saving_cost">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="price">Harga Barang</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control" id="price"
                                            value="{{ old('price') }}" name="price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="unit">Satuan Barang</label>
                                    <select name="unit" id="unit" class="form-control">
                                        <option selected hidden>Pilih Satuan</option>
                                        <option {{ !empty(old('unit')) ? 'selected' : '' }} value="unit">Unit</option>
                                        <option {{ !empty(old('pack')) ? 'selected' : '' }} value="pack">Pack</option>
                                        <option {{ !empty(old('sak')) ? 'selected' : '' }} value="sak">Zak</option>
                                        <option {{ !empty(old('pcs')) ? 'selected' : '' }} value="pcs">Pcs</option>
                                        <option {{ !empty(old('m3')) ? 'selected' : '' }} value="m3">M3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($data as $item)
        <div class="modal fade" id="modal-edit{{ $item->id }}">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Barang {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('master.barang.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="id_barang">ID Barang</label>
                                        <input type="text" class="form-control" name="id_barang"
                                            value="{{ $item->id }}" id="id_barang" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nama Barang</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ !empty(old('name')) ? old('name') : $item->name }}" id="name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="leadtime">Lead Time</label>
                                        <input type="text" class="form-control" name="leadtime"
                                            value="{{ !empty(old('leadtime')) ? old('leadtime') : $item->leadtime }}"
                                            id="leadtime">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="place">Tempat Barang</label>
                                        <select name="place" id="place" class="form-control">
                                            <option selected hidden>Pilih Tempat</option>
                                            <option
                                                {{ old('place') == 'gudang' ? 'selected' : ($item->place == 'gudang' ? 'selected' : '') }}
                                                value="gudang">Gudang
                                            </option>
                                            <option
                                                {{ old('place') == 'toko' ? 'selected' : ($item->place == 'toko' ? 'selected' : '') }}
                                                value="toko">Toko
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="saving_cost">Biaya Simpan Barang</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" id="saving_cost"
                                                value="{{ !empty(old('saving_cost')) ? old('saving_cost') : $item->saving_cost }}"
                                                name="saving_cost">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">Harga Barang</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" id="price" name="price"
                                                value="{{ !empty(old('price')) ? old('price') : $item->price }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="unit">Satuan Barang</label>
                                        <select name="unit" id="unit" class="form-control">
                                            <option selected hidden>Pilih Satuan</option>
                                            <option
                                                {{ (!empty(old('unit')) ? 'selected' : $item->unit == 'unit') ? 'selected' : '' }}
                                                value="unit">Unit
                                            </option>
                                            <option
                                                {{ (!empty(old('pack')) ? 'selected' : $item->unit == 'pack') ? 'selected' : '' }}
                                                value="pack">Pack
                                            </option>
                                            <option
                                                {{ (!empty(old('sak')) ? 'selected' : $item->unit == 'sak') ? 'selected' : '' }}
                                                value="sak">Zak</option>
                                            <option
                                                {{ (!empty(old('pcs')) ? 'selected' : $item->unit == 'pcs') ? 'selected' : '' }}
                                                value="pcs">Pcs</option>
                                            <option
                                                {{ (!empty(old('m3')) ? 'selected' : $item->unit == 'm3') ? 'selected' : '' }}
                                                value="m3">M3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-delete{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Barang {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('master.barang.delete') }}" method="post">
                        @csrf
                        <div class="modal-footer">
                            <input type="number" value="" name="id_barang" hidden>
                            <div style="float: right;">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-detail{{ $item->id }}">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Barang {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5">
                                <p>ID Barang:</p>
                            </div>
                            <div class="col-6">
                                <p>: {{ $item->id }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <p>Nama Barang:</p>
                            </div>
                            <div class="col-6">
                                <p>: {{ $item->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <p>Kuantiti:</p>
                            </div>
                            <div class="col-6">
                                <p>: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <p>Biaya Simpan Barang:</p>
                            </div>
                            <div class="col-6">
                                <p>: Rp{{ number_format($item->saving_cost) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <p>Harga Barang:</p>
                            </div>
                            <div class="col-6">
                                <p>: Rp{{ number_format($item->price) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <p>Satuan Barang:</p>
                            </div>
                            <div class="col-6">
                                <p>: {{ $item->unit }}</p>
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
