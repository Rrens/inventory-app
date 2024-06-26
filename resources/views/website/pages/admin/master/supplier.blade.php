@extends('website.components.master')
@section('title', 'supplier')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Supplier</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
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
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#modal-add">
                                <i class="fa fa-plus-square"></i> Tambah Supplier
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No Telp</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->telp }}</td>
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
                    <h4 class="modal-title">Tambah Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('master.supplier.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="id_supplier">ID Supplier</label>
                                    <input type="text" class="form-control" name="id" value="{{ $id_supplier }}"
                                        id="id_supplier" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nama Supplier</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        id="name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="telp">No Telp</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+62</span>
                                        </div>
                                        <input type="number" class="form-control" id="telp"
                                            value="{{ old('telp') }}" name="telp">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Keterangan</label>
                                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
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
                        <h4 class="modal-title">Edit Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('master.supplier.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="id">ID Supplier</label>
                                        <input type="text" class="form-control" name="id"
                                            value="{{ $item->id }}" id="id" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nama Supplier</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ !empty(old('name')) ? old('name') : $item->name }}" id="name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="telp">No Telp</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+62</span>
                                            </div>
                                            <input type="number" class="form-control" id="telp"
                                                value="{{ !empty(old('telp')) ? old('telp') : $item->telp }}"
                                                name="telp">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Keterangan</label>
                                        <textarea name="description" id="description" rows="5" class="form-control">{{ !empty(old('description')) ? old('description') : $item->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
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
                        <h4 class="modal-title">Detail Supplier {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <p>ID Supplier</p>
                                <p>Nama Supplier</p>
                                <p>No Telp</p>
                                <p>Deskripsi</p>
                            </div>
                            <div class="col-6">
                                <p>{{ $item->id }}</p>
                                <p>{{ $item->name }}</p>
                                <p>+62 {{ $item->telp }}</p>
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data as $item)
        <div class="modal fade" id="modal-delete{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Supplier {{ $item->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('master.supplier.delete') }}" method="post">
                        @csrf
                        <div class="modal-footer">
                            <input type="number" value="{{ $item->id }}" name="id" hidden>
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
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    {{-- <style>
        .action-menu {
            display: none;
            position: absolute;
            top: 30px;
            /* Sesuaikan sesuai kebutuhan */
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .action-menu-item {
            display: block;
            padding: 5px 10px;
            text-decoration: none;
            color: #333;
        }

        .action-menu-item:hover {
            background-color: #f0f0f0;
        }
    </style> --}}
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
    {{-- <script>
        document.getElementById("action-button").addEventListener("click", function() {
            var menu = document.getElementById("action-menu");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            // Data contoh (ganti dengan data yang sesuai)
            var old_data = [{!! $name_supplier !!}];
            var data = old_data.map(function(item) {
                return {
                    name: item
                };
            });

            function searchNamesByIndex(query, index) {
                return data.filter(function(item) {
                    console.log(item.name[0])
                    return item.name[index].toLowerCase().indexOf(query.toLowerCase()) !== -1;
                });
            }

            // Fungsi untuk menampilkan hasil pencarian
            function renderSearchResults(results) {
                $(".info-box").hide(); // Sembunyikan semua info-box

                // Jika pencarian kosong, tampilkan semua info-box
                if (!results || results.length === 0) {
                    $(".info-box").show();
                    return;
                }

                // Tampilkan info-box yang sesuai dengan hasil pencarian
                $.each(results, function(_, item) {
                    $(".info-box").filter(function() {
                        return $(this).find(".info-box-text").text().toLowerCase() === item.name
                            .toLowerCase();
                    }).show();
                });
            }

            // Memanggil fungsi pencarian saat input berubah
            $("#searchInput").on("input", function() {
                var query = $(this).val();
                var index = 0; // Misalnya, Anda ingin mencari berdasarkan indeks pertama
                var results = searchNamesByIndex(query, index);
                renderSearchResults(results);
            });
        });
    </script> --}}
@endpush
