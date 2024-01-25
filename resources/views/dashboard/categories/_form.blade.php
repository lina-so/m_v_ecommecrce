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
    <div class="form-group">
        <x-form.input name="name" value="{{ $category->name }}" type="text" label="Category Name"/>

        {{-- <label for="">category name</label> --}}
        {{-- <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$category->name) }}">
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror --}}
    <div>



    {{-- parent --}}
    <div class="form-group">
        <label for="">category parent</label>
        <select name="parent_id" id=""class="form-control form-select">
            <option value="">Primary Category</option>

            @foreach ($categoryParents as $parent )
            <option value="{{ $parent->id }}" @selected(old('parent_id',$category->parent_id) == $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- description --}}
    <div class="form-group">
        <x-form.textarea name="description"  cols="5" rows="5" :value="$category->description" label="description" ></x-form.textarea>
    </div>

    {{-- image --}}
    <div class="form-group">
        <x-form.label id="Image">category image</x-form.label>
        <x-form.input type="file" name="image" />
        @if ($category->image)
           <td><img src="{{ asset('storage/'. $category->image) }}" alt="" height="30" width="50"></td>
        @endif
    </div>

     {{-- status --}}
     <div class="form-group">
        <label for="">category status</label>
        <div>
          <x-form.radio   type="radio" name='status'  :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']"  class="mr-5" />

        {{-- <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
            <input type="radio" aria-label="Radio button for following text input" name="status" value="archived" class="mr-5" @checked(old('status',$category->status) == 'archived')>
            <label for="">archived</label>
            </div>
        </div>
        </div> --}}

        </div>
    </div>

    <div class="form-group">
        @if ($category->exists)
        <button type="submit" class="mt-3 btn btn-primary">edit Category</button>
        @else
        <button type="submit" class="mt-3 btn btn-primary">Add Category</button>
        @endif



    </div>
