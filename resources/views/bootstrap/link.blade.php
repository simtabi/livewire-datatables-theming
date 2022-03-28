<a href="{{ $href ?? '#' }}" target="{{$target ?? '_self'}}" class="{{$class ?? 'btn btn-link'}} p-0 m-0" {{$attributes ?? ''}}>
    {!! $label ?? 'Some label' !!}
</a>
