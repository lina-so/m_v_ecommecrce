

{{-- <input type="{{ $type ?? 'text' }}" name="{{ $name }}" @class(
    [
        'form-control',
        'is-invalid'=>$errors->has($name)
    ]
) value="{{ old($name,$value) }}">
@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror --}}



{{-- another way --}}
{{--
@props([
    'type' => 'text' , 'name' ,'value'=> '' , 'label'=> false
])

@if ($label)
<label for="">{{ $label }}</label>
@endif

<input type="{{ $type ?? 'text' }}"
       name="{{ $name }}"
       value="{{ old($name,$value) }}"
       {{ $attributes->class([
        'form-control',
        'is-invalid'=>$errors->has($name)
       ]) }} >

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror --}}


@props([
    'type'=>'text' , 'name', 'value'=> '' , 'label'=>false
])

@if($label)
<label for="">{{ $label }}</label>
@endif
<input type="{{ $type ?? 'text' }}" name="{{ $name }}"
        {{ $attributes->class([
            'form-control',
            'is-invalid'=>$errors->has($name)
        ]) }}
      value="{{ old($name,$value) }}">

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
