@extends('index')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Variant Product</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Variant List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 30%">
                                ID
                            </th>
                            <th style="width: 30%">
                                Title
                            </th>
                            <th style="width: 30%">
                                Price
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $variants ?? '' as $ls)
                            <tr>
                                <td>
                                    {{$ls->id}}
                                </td>
                                <td>
                                    {{$ls->variants_title}}
                                </td>
                                <td>
                                    {{$ls->price}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="row">
                <div class="col-12">
                    <a href="/product/getlist" class="btn btn-secondary">Back to Products</a>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
