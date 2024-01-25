@props([
    'name' , 'options' ,'checked'=>false ,'type'
])

@foreach ( $options as $value => $text )
<div class="input-group mb-3">
    <div class="input-group-prepend">
      <div class="input-group-text">
        <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"  @checked(old($name,$checked) == $value)
        {{ $attributes->class([
            'is-invalid'=>$errors->has($name)

        ]) }}
        >
        <label for="">{{ $text }}</label>
      </div>
    </div>
</div>
@endforeach

