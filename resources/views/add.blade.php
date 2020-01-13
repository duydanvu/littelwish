@extends('index')
@section('content')
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $("select").change(function () {
                var _token = $('input[name="_token"]').val();
                var locale = $('[name= product_locales]').val();
                var id = $('[name = product_id]').val();
                var dataP ={
                    "_token": "{{ csrf_token() }}"
                    ,id
                    ,locale
                };
                console.log(id,locale);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type:"POST",
                    url:"{{route('getAjaxProduct')}}",
                    data: dataP,
                    dataType: "json",
                    success: function (resultData) {
                        console.log(resultData);
                        const myObjStr = JSON.stringify(resultData);
                        if (resultData.length == 0){
                            var dt = $('#product_title_edit').val(" ");
                            var dt2 = $('#inputDescription').text(" ");
                            console.log(dt2);
                        }else{
                            if(myObjStr.split('"')[3] === undefined && myObjStr.split('"')[7] !== undefined){
                                var dt = $('#product_title_edit').val(" ");
                                var dt2 = $('#inputDescription').text(myObjStr.split('"')[7].valueOf());
                            }else if(myObjStr.split('"')[3] !== undefined && myObjStr.split('"')[7] === undefined){
                                var dt = $('#product_title_edit').val(myObjStr.split('"')[3].valueOf());
                                var dt2 = $('#inputDescription').text(" ");
                            }else{
                                var dt = $('#product_title_edit').val(myObjStr.split('"')[3].valueOf());
                                var dt2 = $('#inputDescription').text(myObjStr.split('"')[7].valueOf());
                            }
                        }
                    }
                })
            })
        })
    </script>

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="product/getlist">Product</a></li>
                        <li class="breadcrumb-item active">Product Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
            @if (session('status'))
                <div class="alert alert-success" style="background-color: red">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert">x</button>
                </div>
            @endif
        <form method="post" action="product/postnew/{{$product->id}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Locales Default</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputSku">Product Title </label>
                            <input name="product_id" value="{{$product->product_id}}" hidden>
                            <input type="text" name="product_sku" class="form-control" value="{{$product->title}}">
                        </div>
                        <div class="form-group">
                            <label for="inputTitle">Product Handle </label>
                            <input type="text" name="product_title" class="form-control" value="{{$product->handle}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Product Description </label>
{{--                            <input type="text" name="product_description" class="form-control" value="{{$product->description}}">--}}
                            <textarea id="Description" class="form-control" rows="4" >{{strip_tags($product->description,'p') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputLocales">Locales</label>
                            <input type="text" name="product_locales_1" class="form-control" value="{{$product->locales}}" readonly>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3>Change Locales</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputSku">Product Title </label>
                            <input type="text" name="product_title_edit" class="form-control" id="product_title_edit">
                        </div>
                        <div class="form-group">
                            <label for="inputTitle">Product Handle </label>
                            <input type="text" name="product_handle" class="form-control" value="{{$product->handle}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Product Description </label>
                            <textarea id="inputDescription" class="form-control" rows="4" name="inputDescription"></textarea>
                        </div>
{{--                        <form action="{{route("product/locales")}}" method="POST" enctype="multipart/form-data">--}}
                        <div class="form-group">
                            <label for="inputLocales">Locales </label>
                            <select class="browser-default custom-select" name="product_locales" id="product_locales_edit">
                                <option selected value="">Open this select locales</option>
                                <option value="ja">Japan</option>
                                <option value="sp">Spain</option>
                                <option value="ko">Korean</option>
                            </select>
                        </div>
{{--                        </form>--}}
{{--                        <button class="btn btn-info" id="btn" data-dismiss="modal" onclick="getlocales();">Check</button>--}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="/product/getlist" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Save Product" class="btn btn-success float-right">
            </div>
        </div>
        </form>
    </section>
    <!-- /.content -->
</div>
    <script type="text/javascript">
    </script>
@endsection
