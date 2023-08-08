@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li ><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-category"></i> @lang('site.categories')</li>
            </ol>
        </section>

        <section class="content">



            <div class="box box-primary">

                <div class="box-header with-border ">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories')<small>{{$categories->total()}}</small></h3>

                    <form action="{{ route('dashboard.categories.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" id="searchUser" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" id="category-search"><i class="fa fa-search"></i> @lang('site.search')</button>
@can('category_create')
                                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button disabled class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>

                                @endcan
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div>
                <div class="box-body border-radius-none">
                    @if($categories->count()>0)
                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.products_count')</th>
                                <th>@lang('site.related_products')</th>

                                <th>@lang('site.action')</th>
                            </tr>


                        </thead>

                            <tbody>
                            @foreach($categories as $index=>$category)
                                <tr>
                                    <td>{{$index + 1 }}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->products->count()}}</td>
                                    <td><a href="{{route('dashboard.products.index',['category_id'=>$category->id])}}" class="btn btn-info btn-sm ">@lang('site.related_products')</a></td>


                                    <td>
                                        @can('category_update')
                                            <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</a>

                                        @else
                                            <button disabled class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</button>

                                        @endcan
                                        @can('category_delete')
                                            <form style="display: inline-block" action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
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
                        {{ $categories->appends(request()->query())->links('vendor.pagination.default') }}
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

