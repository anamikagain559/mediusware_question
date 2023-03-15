@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="{{ route('products.search') }}" method="GET" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">

                    {{-- <select name="variant_id[]" class="form-control" multiple>
                        <option value="">Select a variant</option>
                        @foreach ($variants as $variant)
                            <optgroup label="{{ $variant->title }}">
                                @foreach ($variant->productVariants as $productVariant)
                                    <option value="{{ $productVariant->id }}" {{ in_array($productVariant->id, (array)request('variant_id')) ? 'selected' : '' }}>
                                        {{ $variant->title }} - {{ $productVariant->variant ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select> --}}
                    <select name="variant_id[]" class="form-control" multiple>
                        <option value="">Select a variant</option>
                        @foreach ($variants as $variant)
                            <optgroup label="{{ $variant->title }}">
                                @foreach ($variant->productVariants as $productVariant)
                                    <option value="{{ $productVariant->id }}"
                                        {{ in_array($productVariant->id, (array) request('variant_id')) ? 'selected' : '' }}>
                                        {{ $productVariant->variant ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From"
                            class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table" id="example1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Variant</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>

                    <tbody>


                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->title }}<br> Created at :
                                    {{ date('d-m-Y', strtotime($product->created_at)) }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($product->description, 50, '...') }}</td>
                                <td>
                                    <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">
                                        @foreach ($product->variantPrices as $variantPrice)
                                            <dt class="col-sm-3 pb-0">
                                                {{ $variantPrice->variantOne->variant ?? 'N/A' }}/
                                                {{ $variantPrice->variantTwo->variant ?? 'N/A' }}
                                                /{{ $variantPrice->variantThree->variant ?? 'N/A' }}

                                            </dt>
                                            <dd class="col-sm-9">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-4 pb-0">Price :{{ $variantPrice->price }}</dt>
                                                    <dd class="col-sm-8 pb-0">InStock : {{ $variantPrice->stock }}</dd>
                                                </dl>
                                            </dd>
                                        @endforeach
                                    </dl>
                                    <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show
                                        more</button>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                                    </div>
                                </td>
                        @endforeach

                        </tr>



                    </tbody>

                </table>
            </div>
            <div class="d-flex justify-content-center">{{ $products->links() }}</div>
        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing 1 to 10 out of 100</p>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'>
    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js'></script>
@endsection
