@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li ><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-user"></i> @lang('site.users')</li>
            </ol>
        </section>

        <section class="content">



            <div class="box box-primary">

                <div class="box-header with-border ">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users')<small>{{$users->total()}}</small></h3>

                    <form action="{{ route('dashboard.users.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
@can('user_create')
                                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button disabled class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>

                                @endcan
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div>
                <div class="box-body border-radius-none">
                    @if($users->count()>0)
                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.action')</th>
                            </tr>


                        </thead>

                            <tbody>
                            @foreach($users as $index=>$user)
                                <tr>
                                    <td>{{$index + 1 }}</td>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <img src="{{$user->image}}" style="width: 50px;height: 50px" class="img-thumbnail">
                                    </td>


                                    <td>
                                        @can('user_update')
                                            <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</a>

                                        @else
                                            <button disabled class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</button>

                                        @endcan
                                        @can('user_delete')
                                            <form style="display: inline-block" action="{{route('dashboard.users.destroy',$user->id)}}" method="post">
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
                        {{ $users->appends(request()->query())->links('vendor.pagination.default') }}
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

