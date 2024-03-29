@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li ><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-client"></i> @lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">



            <div class="box box-primary">

                <div class="box-header with-border ">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.clients')<small>{{$clients->total()}}</small></h3>

                    <form action="{{ route('dashboard.clients.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
@can('client_create')
                                    <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button disabled class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>

                                @endcan
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div>
                <div class="box-body border-radius-none">
                    @if($clients->count()>0)
                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.add_order')</th>
                                <th>@lang('site.action')</th>
                            </tr>


                        </thead>

                            <tbody>
                            @foreach($clients as $index=>$client)
                                <tr>
                                    <td>{{$index + 1 }}</td>
                                    <td>{{$client->name}}</td>
                                    <td>{{$client->email}}</td>
                                    <td>{{implode('-',$client->phone)}}</td>
                                    <td>{{$client->address}}</td>
                                    <td>
                                        @can('order_create')
                                            <a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>@lang('site.add_order')</a>

                                        @else
                                            <button disabled class="btn btn-success btn-sm"><i class="fa fa-plus"></i>@lang('site.add_order')</button>

                                        @endcan
                                    </td>

                                    <td>
                                        @can('client_update')
                                            <a href="{{route('dashboard.clients.edit',$client->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</a>

                                        @else
                                            <button disabled class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</button>

                                        @endcan
                                        @can('client_delete')
                                            <form style="display: inline-block" action="{{route('dashboard.clients.destroy',$client->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i>@lang('site.delete')</button>

                                            </form>
                                        @else
                                            <button disabled class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                            @endcan

                                    </td>


                                </tr>
                            @endforeach

                            </tbody>

                    </table>
                        {{ $clients->appends(request()->query())->links('vendor.pagination.default') }}
                    @else
                        <div class="alert alert-danger">
                            <p>@lang('site.no_data_found')</p>
                        </div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

