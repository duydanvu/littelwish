@extends('index')
@section('content')
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="view-dashboard content content--main">
        <div class="content-header">

            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h2>Overview Report</h2>
                </div>
                <div class="col-sm-6 col-xs-12 text-right">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                @php  $totalSearchQueries = 0;$totalSearchNoResult = 0; @endphp
                @foreach($dataSearchQueries as $value)
                    @php $totalSearchQueries +=  $value->total @endphp
                @endforeach

                @foreach($dataSearchNoResult as $value)
                    @php $totalSearchNoResult +=  $value->total @endphp
                @endforeach
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$totalSearchQueries + $totalSearchNoResult}}</h3>

                        <p>Search Count The Total</p>
                    </div>
                    <div class="icon">
                        <i class="ion-search"></i>
                    </div>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">

                        <h3>{{$totalSearchQueries}}</h3>

                        <p>Search Count  With Results</p>
                    </div>
                    <div class="icon">
                        <i class="ion-android-favorite-outline"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-4">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">

                        <h3>{{$totalSearchNoResult}}</h3>

                        <p>Search Count  With No Results</p>
                    </div>
                    <div class="icon">
                        <i class="ion-ios-color-filter-outline"></i>
                    </div>
                </div>
            </div>

            <!-- ./col -->
        </div>

{{--        <div class="row">--}}
{{--            <div class="col-sm-12 col-xs-12">--}}
{{--                <div class="box box-list">--}}
{{--                    <div class="box-body">--}}
{{--                        <div class="box-header ui-sortable-handle" style="cursor: move;">--}}

{{--                            <h3 class="box-title">Chart  Search queries with results</h3>--}}

{{--                        </div>--}}
{{--                        <div class="cavas_report--main">--}}
{{--                            <div class="cavas_report">--}}
{{--                                <canvas id="added-chart" style="height: 265px; width: 530px;" width="530" height="265"></canvas>--}}
{{--                                <div>--}}
{{--                                    <ul id="added-chart-legend"></ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
        <div class="row">
            <div class="col-md-6">
                <div class="box box-list">
                    <div class="offer-by-view-box box-body">
                        <div class="box-header">
                            <h3 class="box-title">Top search queries with results</h3>
                        </div>

                        <table id="snize_table_top_search_queries" cellpadding="0" cellspacing="0" border="0" class="table table-striped snize-view snize-table-with-shadow">
                            <thead>
                            <tr class="snize-headings">
                                <th>#</th>
                                <th>Phrase</th>
                                <th>Search count</th>
                                <th>% of all searches</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(!$dataSearchQueries->isEmpty() )

                                @php  $otherResult = 0; @endphp
                                @foreach($dataSearchQueries as $value)

                                    @if( $loop->iteration	 <= 9 )
                                        <tr>
                                            <td>
                                                {{ $loop->iteration	}}

                                            </td>
                                            <td>
                                                {{$value->phrase}}
                                            </td>
                                            <td class="ls-name">
                                                {{$value->total}}
                                            </td>
                                            <td class="ls-type">
                                                {{round(($value->total  /$totalSearchQueries)*100,2)}}%

                                            </td>

                                        </tr>
                                    @else
                                        @php  $otherResult += $value->total @endphp
                                        @if ($loop->last)
                                            <tr>
                                                <td>
                                                    10
                                                </td>
                                                <td>
                                                    Other phrase
                                                </td>
                                                <td class="ls-name">
                                                    {{$otherResult  }}
                                                </td>
                                                <td class="ls-type">
                                                    {{round(($otherResult  /$totalSearchQueries)*100,2)}}%

                                                </td>

                                            </tr>
                                        @endif


                                    @endif


                                @endforeach

                            @else
                                <tr>
                                    <td colspan="3" class="center">No phrases</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-list">
                    <div class="offer-by-conversion-box box-body">
                        <div class="box-header">
                            <h3 class="box-title">Top search with no results</h3>
                        </div>
                        <table id="snize_table_top_no_results_search_queries" cellpadding="0" cellspacing="0" border="0" class="table table-striped snize-view snize-table-with-shadow">
                            <thead>
                            <tr class="snize-headings">
                                <th>#</th>
                                <th>Phrase</th>
                                <th>Search count</th>
                                <th>% of all searches</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if( !$dataSearchNoResult->isEmpty() )
                                @php $otherNoResult = 0; @endphp
                                @foreach($dataSearchNoResult as $value)
                                        @if( $loop->iteration <= 9 )
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration}}
                                                </td>
                                                <td>
                                                    {{$value->phrase}}
                                                </td>
                                                <td class="ls-name">
                                                    {{$value->total}}
                                                </td>
                                                <td class="ls-type">
                                                    {{round(($value->total  /$totalSearchNoResult)*100,2)}}%

                                                </td>

                                            </tr>
                                        @else
                                            @php  $otherNoResult += $value->total @endphp
                                            @if ($loop->last)
                                                <tr>
                                                    <td>
                                                        10
                                                    </td>
                                                    <td>
                                                        Other phrase
                                                    </td>
                                                    <td class="ls-name">
                                                        {{$otherNoResult  }}
                                                    </td>
                                                    <td class="ls-type">
                                                        {{round(($otherNoResult  /$totalSearchNoResult)*100,2)}}%

                                                    </td>

                                                </tr>
                                            @endif


                                        @endif
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="3" class="center">No phrases</td>
                                </tr>
                            @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    </div>
@endsection
@section('page-script')
@stop
