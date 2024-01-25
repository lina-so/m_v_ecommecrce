@extends('dashboard.layouts.main')

@section('title','options')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

<div class="p-3">
    <form action="{{ route('dashboard.options.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.options._form')
    </form>
</div>

@endsection

