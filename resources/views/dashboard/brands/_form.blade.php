    @if ($errors->any())
        <div class="alert alert-danger">
            <h4>Error Occured!</h4>
            <ul>
                @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    @if (session('customError'))
    <div class="alert alert-danger">
        <h4>Error Occurred!</h4>
        <p>{{ session('customError') }}</p>
    </div>
@endif


    {{-- name --}}
    <div class="form-group" >
        <x-form.input name="name[]"  type="text"  label="Brand Name" id="inputField"  placeholder="brand name" value="{{$brand->name}}"/>
    <div>


    <div class="form-group">
        @if ($brand->exists)
        <button type="submit" class="mt-3 btn btn-primary">edit Brand</button>
        @else
        <button type="submit" class="mt-3 btn btn-primary" id="submit">Add Brand</button>
        @endif
    </div>
