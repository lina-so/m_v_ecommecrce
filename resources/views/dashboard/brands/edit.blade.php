@extends('dashboard.layouts.main')

@section('title', 'Brands')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <div class="p-3">
        <form action="{{ route('dashboard.brands.update', $brand->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- name --}}
            <div class="form-group">
                <x-form.input name="name" type="text" label="Brand Name" id="inputField" placeholder="brand name"
                    value="{{ $brand->name }}" />
            <div>

            <div class="form-group">
                <button type="submit" class="mt-3 btn btn-primary">edit Brand</button>
            </div>

        </form>
    </div>

@endsection
