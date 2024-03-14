@extends('website.components.master')
@section('title', 'barang')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengelolaan Barang Masuk</h1>
                </div><!-- /.col -->
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
                            <h3 class="card-title">Data Supplier</h3>
                            <button type="button" class="btn btn-outline-primary btn-sm" style="float: right;"
                                data-toggle="modal" data-target="#modal-add">
                                <i class="fa fa-plus-square "></i>
                                Tambah Supplier
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="id_supplier">ID Supplier</label>
                                        <input type="text" class="form-control" name="id_supplier"
                                            value="{{ old('id_supplier') }}" id="id_supplier">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nama Supplier</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" id="name">
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
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@push('css')
@endpush
@push('script')
@endpush
