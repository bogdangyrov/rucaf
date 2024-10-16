<h1>Оборудование:</h1>
@foreach ($types as $type)
    <div>
        <a href="/catalog/{{ $type->slug }}">{{ $type->name }}</a>
    </div>
@endforeach
