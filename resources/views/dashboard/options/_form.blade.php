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

    {{-- options --}}
    <div class="form-group options-container">
        <div class="option">

        </div>
    </div>

    <button type="button" class="btn btn-success add-option-btn">Add Option</button>




    <div class="form-group">
            <button type="submit" class="mt-3 btn btn-primary" >Submit</button>
    </div>


    @push('scripts')
        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


        {{-- add options & values --}}
        <script>
            $(document).ready(function() {
                var optionCounter = 0;

                $('.add-option-btn').click(function() {
                    var optionTemplate = `
             <div class="option">
                 <div class="mb-2">

                   <x-form.input name="options[${optionCounter}][option_name]" value="{{ $option->name }}" type="text" label="option Name" placeholder="option name ex: color"/>

                 </div>
                 <div class="values-container" data-option="${optionCounter}" data-counter="0">
                     <!-- ... Value inputs will be added here ... -->
                 </div>
                 <button type="button" class="btn btn-primary add-value-btn ml-5">Add Value</button>
                 <br>
                 <button type="button" class="btn btn-danger remove-option-btn mb-3"><i class="fas fa-trash"></i></button>
             </div>
         `;
                    $('.options-container').append(optionTemplate);
                    optionCounter++;
                });

                $(document).on('click', '.add-value-btn', function() {
                    var valuesContainer = $(this).prev('.values-container');
                    var optionIndex = valuesContainer.data('option');
                    var counter = valuesContainer.data('counter');
                    var valueTemplate = `
             <div class="value">
                 <input type="text" name="options[${optionIndex}][values][${counter}][value]" class="form-control ml-5" placeholder="Value Name ex: pink">
                 <button type="button" class="btn btn-outline-danger remove-value-btn ml-5 mb-3 mt-1"><i class="fas fa-trash fa-sm "></i></button>
                 <br>
             </div>
         `;
                    valuesContainer.append(valueTemplate);
                    valuesContainer.data('counter', counter + 1);
                });

                $(document).on('click', '.remove-option-btn', function() {
                    $(this).closest('.option').remove();
                });

                $(document).on('click', '.remove-value-btn', function() {
                    $(this).closest('.value').remove();
                });
            });
        </script>
    @endpush
