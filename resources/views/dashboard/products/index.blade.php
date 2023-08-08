@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li ><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-product"></i> @lang('site.products')</li>
            </ol>
        </section>

        <section class="content">



            <div class="box box-primary">

                <div class="box-header with-border ">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products')<small>{{$products->total()}}</small></h3>

                    <form action="{{ route('dashboard.products.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <select name="category_id" class="form-control" >
                                    <option value="">@lang('site.all_categories') </option>

                                @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
@can('product_create')
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button disabled class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>

                                @endcan
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div>
                <div class="box-body border-radius-none">
                    @if($products->count()>0)
                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.profit_percent') %</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.action')</th>
                            </tr>


                        </thead>

                            <tbody>
                            @foreach($products as $index=>$product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{ $product->category->name }}</td>


                                        <td><img src="{{$product->image_path}}" style="width: 100px"  class="img-thumbnail" alt=""></td>


                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->sale_price }}</td>
                                    <td>{{ $product->profit_percent }} %</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @can('product_update')
                                            <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</a>

                                        @else
                                            <button disabled class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.edit')</button>

                                        @endcan
                                        @can('product_delete')
                                            <form style="display: inline-block" action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
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
                        {{ $products->appends(request()->query())->links('vendor.pagination.default') }}
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

