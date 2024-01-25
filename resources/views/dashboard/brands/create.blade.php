@extends('dashboard.layouts.main')

@section('title','Brands')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

<div class="p-3">
    <form action="{{ route('dashboard.brands.store') }}" method="post" enctype="multipart/form-data" id="mainForm">
        @csrf
        @include('dashboard.brands._form')
        <button type="button" onclick="duplicateInput()" class="btn btn-outline-success text-md-center">+</button>
    </form>
</div>

@endsection


@push('scripts')
<script>
      function duplicateInput() {
        var originalInput = document.getElementById('inputField');
        var clonedInput = originalInput.cloneNode(true);

        var lineBreak = document.createElement('br');

        var form = document.getElementById('mainForm');
        form.insertBefore(clonedInput, form.lastElementChild);
        form.insertBefore(lineBreak, form.lastElementChild);
    }
</script>

@endpush
