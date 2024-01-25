@extends('dashboard.layouts.main')

@section('title','Products')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

<div class="p-3">
    <form action="{{ route('dashboard.products.update',$product->id) }}" method="post" enctype="multipart/form-data" id="mainForm">
        @csrf
        @method('PUT')
        @include('dashboard.products._form')
    </form>
</div>

@endsection
