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
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users')</h3>

                    <form action="{{ route('dashboard.users.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>

                            </div>

                        </div>
                    </form><!-- end of form -->

                </div>
                <div class="box-body border-radius-none">
                    @if($permissions->count()>0)
                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>@lang('site.role')</th>
                                <th>@lang('site.permissions')</th>
                                <th>@lang('site.action')</th>
                            </tr>


                        </thead>

                            <tbody>
                            @foreach($roles as $role)

                                <tr>
                                    <td>{{$role->id }}</td>
                                    <td>{{$role->name}}</td>

                                    <td>
                                        @foreach($role->permissions as $permission)
                                            {{$permission->name}} ,
                                        @endforeach
                                    </td>

                                    <td>
                                        <a href="{{route('dashboard.users.edit',$role->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                        <form style="display: inline-block" action="{{route('dashboard.users.destroy',$role->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>@lang('site.delete')</button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                    </table>
                    @else
                        <div class="alert alert-danger">
                            <h3>@lang('site.no_data_found')</h3>
                        </div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

