@if ($errors->any())
<div class="alert alert-danger">
    <h4>Error Occured!</h4>
    <ul>
        @foreach ($errors->all() as $error)
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
<x-form.input name="name" value="{{ $product->name }}" type="text" label="Product Name" />
</div>

{{-- Main Category --}}
<div class="form-group">
<label for="category_id">Main Category</label>
<select name="category_id" id="category_id" class="form-control">
    <option value="">Select Main Category</option>
    @foreach ($categories as $mainCategory)
        <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
    @endforeach
</select>
</div>

{{-- Subcategory --}}
<div class="form-group">
<label for="parent_id">Subcategory </label>
<select name="parent_id" id="subcategory_id" class="form-control">
    <!-- Options will be dynamically populated using JavaScript -->
</select>
</div>


{{-- brand --}}
<div class="form-group">
<label for="">brand</label>
<select name="brand_id" id=""class="form-control form-select">
    <option value="" class="checked">choose</option>

    @foreach ($brands as $brand)
        <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
    @endforeach
</select>
</div>


{{-- vendor --}}
<div class="form-group">
<label for="">vendor</label>
<select name="vendor_id" id=""class="form-control form-select">
    <option value="" class="checked">choose</option>

    @foreach ($vendors as $vendor)
        <option value="{{ $vendor->id }}" @selected(old('vendor_id', $product->vendor_id) == $vendor->id)>{{ $vendor->name }}</option>
    @endforeach
</select>
</div>


{{-- quantity --}}
<div class="form-group">
<x-form.input name="quantity" value="{{ $product->quantity }}" type="number" label="Quantity" />
</div>


{{-- description --}}
<div class="form-group">
<x-form.textarea name="description" cols="5" rows="5" :value="$product->description"
    label="description"></x-form.textarea>
</div>


{{-- image --}}
<div class="form-group">
<x-form.label id="Image">product image</x-form.label>
<x-form.input type="file" name="image[]" multiple />
</div>




{{-- price --}}
<div class="form-group">
<x-form.input name="price" value="{{ $product->price }}" type="number" label="Price" />
</div>

{{-- compare price --}}
<div class="form-group">
<x-form.input name="compare_price" value="{{ $product->compare_price }}" type="number"
    label="Compare Price (%)" />
</div>


{{-- status --}}
<div class="form-group">
<label for="">product status</label>
<div>
    <x-form.radio type="radio" name='status' :checked="$product->status" :options="[
        'active' => 'Active',
        'archived' => 'Archived',
        'draft' => 'Draft',
    ]" class="mr-5" />
</div>
</div>

{{-- featured --}}
<div class="form-group">
<label for="">featured</label>
<div>
    <x-form.radio type="radio" name='featured' :checked="$product->featured" :options="['1' => 'true']" class="mr-5" />
</div>
</div>

<div class="form-group optionValues" id="inputField">

    
{{-- options --}}
<div class="form-group options-container">
    <label for="" class="form-label">Options</label>
    <div class="mb-2">
        <select class="form-control" name="options[${optionCounter}][option_id]" id="optionsDropdown">
            @foreach ($options as $option)
                <option value="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- Values --}}
<div class="form-group values-container">
    <label for="" class="form-label">Values</label>
    <div class="mb-2">
        <select class="form-control" name="options[${optionCounter}][values][]" id="valuesDropdown" multiple>
            <!-- Values will be dynamically populated based on the selected option -->
        </select>
    </div>
</div>
</div>

<button type="button" onclick="duplicateInput()" class="btn btn-outline-success text-md-center">+</button>





<div class="form-group">
@if ($product->exists)
    <button type="submit" class="mt-3 btn btn-primary">edit
        Product</button>
@else
    <button type="submit" class="mt-3 btn btn-primary">Submit</button>
@endif
</div>


@push('scripts')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<!-- other script tags -->
<script>
    $(document).ready(function() {
        $('#category_id').on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                // Fetch subcategories based on the selected main category
                $.ajax({
                    url: '/admin/dashboard/get-subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        // Clear existing options
                        $('#subcategory_id').empty();
                        // Add new options based on the response
                        $.each(data, function(id, name) {
                            $('#subcategory_id').append($('<option>', {
                                value: id,
                                text: name
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                // If no main category selected, clear subcategory options
                $('#subcategory_id').empty();
            }
        });
    });
</script>


{{-- add options & values --}}

<script>
    $(document).ready(function() {
        $('#optionsDropdown').on('change', function() {
            var selectedOptionId = $(this).val();
            if (selectedOptionId) {
                $.ajax({
                    url: '/admin/dashboard/get-option-values/' + selectedOptionId,
                    type: 'GET',
                    success: function(data) {
                        $('#valuesDropdown').empty();
                        $.each(data, function(id, name) {
                            $('#valuesDropdown').append($('<option>', {
                                value: id,
                                text: name
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#valuesDropdown').empty();
            }
        });
    });
</script>

{{-- copy option value  --}}
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
