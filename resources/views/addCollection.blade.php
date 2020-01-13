@extends('index')
@section('content')
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $("select").change(function () {
                var _token = $('input[name="_token"]').val();
                var locale = $('[name= collection_locales]').val();
                var id = $('[name = collection_id]').val();
                var dataP ={
                    "_token": "{{ csrf_token() }}"
                    ,id
                    ,locale
                };
                console.log(id,locale);
                $.ajax({
                    type:"POST",
                    url:"{{route('getAjaxCollection')}}",
                    data: dataP,
                    dataType: "json",
                    success: function (resultData) {
                        console.log(resultData);
                        const myObjStr = JSON.stringify(resultData);
                        if (resultData.length == 0){
                            var dt = $('#collection_title_edit').val(" ");
                            var dt2 = $('#inputDescription').text(" ");
                            console.log(dt2);
                        }else{
                            if(myObjStr.split('"')[3] === undefined && myObjStr.split('"')[7] !== undefined){
                                var dt = $('#collection_title_edit').val(" ");
                                var dt2 = $('#inputDescription').text(myObjStr.split('"')[7].valueOf());
                            }else if(myObjStr.split('"')[3] !== undefined && myObjStr.split('"')[7] === undefined){
                                var dt = $('#collection_title_edit').val(myObjStr.split('"')[3].valueOf());
                                var dt2 = $('#inputDescription').text(" ");
                            }else{
                                var dt = $('#collection_title_edit').val(myObjStr.split('"')[3].valueOf());
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
                        <h1>Collection</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="collections/getlist">Collection</a></li>
                            <li class="breadcrumb-item active">Collection Detail</li>
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
            <form method="post" action="collection/postnew/{{$collection->id}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3>Locales Default</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputSku">Collection Title </label>
                                    <input name="collection_id" value="{{$collection->collection_id}}" hidden>
                                    <input type="text" name="product_sku" class="form-control" value="{{$collection->title}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputTitle">Collection Handle </label>
                                    <input type="text" name="product_title" class="form-control" value="{{$collection->handle}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Collection Description </label>
                                    <textarea id="inputDescription1" class="form-control" rows="4" >{{$collection->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputLocales">Locales</label>
                                    <input type="text" name="product_locales" class="form-control" value="{{$collection->locales}}" readonly>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    @yield('locales')
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3>News Locales</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputSku">Collection Title </label>
                                    <input type="text" name="collection_title" class="form-control" id="collection_title_edit">
                                </div>
                                <div class="form-group">
                                    <label for="inputTitle">Collection Handle </label>
                                    <input type="text" name="collection_handle" class="form-control" value="{{$collection->handle}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Collection Description </label>
                                    <textarea id="inputDescription" class="form-control" rows="4" name="collection_description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputLocales">Locales </label>
                                    <select class="browser-default custom-select" name="collection_locales">
                                        <option selected value="">Open this select locales</option>
                                        <option value="ja">Japan</option>
                                        <option value="sp">Spain</option>
                                        <option value="ko">Korean</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="/collections/getlist" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Add Collection" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
@endsection

