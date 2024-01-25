@extends('dashboard.layouts.main')

@section('title', 'Edit Options')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <div class="p-3">

        <form method="POST" action="{{ route('dashboard.options.update', $option->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="option_name" class="form-label"> option name:</label>
                <input type="text" name="option_name" value="{{ $option->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="values" class="form-label">values:</label>
                <div id="values-container">
                    @foreach ($option->values as $index => $value)
                        <div class="input-group mb-3">
                            <input type="text" name="values[{{ $index }}][name]" value="{{ $value->name }}" class="form-control" required>
                            <button type="button" onclick="removeValueField(this)" class="btn btn-danger">delete</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <button type="button" onclick="addValueField()" class="btn btn-success"> Add value +</button>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">save</button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    var index = {{ count($option->values) }};

    function addValueField() {
        var valuesContainer = document.querySelector('#values-container');
        var valueField = document.createElement('div');
        valueField.innerHTML = `
            <div class="input-group mb-3">
                <input type="text" name="values[${index}][name]" value="" class="form-control" required>
                <button type="button" onclick="removeValueField(this)" class="btn btn-danger">delete</button>
            </div>
        `;
        valuesContainer.appendChild(valueField);
        index++; // Increment the index for the next field
    }

    function removeValueField(button) {
        button.parentNode.remove();
    }
</script>
@endpush
