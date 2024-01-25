
@if (session()->has($type))
<div class="alert alert-{{$type}}" role="alert">
    {{ session($type) }}
</div>
@endif

