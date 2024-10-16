<h1>Оборудование:</h1>
@foreach ($types as $type)
    <div>
        <a href="/catalog/{{ $type->id }}">{{ $type->name }}</a>
    </div>
@endforeach
