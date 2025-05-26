@extends('layouts.app')

@section('content')
    <h2>Lista de Propietarios</h2>

    <ul>
        @foreach ($propietarios as $propietario)
            <li>{{ $propietario->name }} - {{ $propietario->email }}</li>
        @endforeach
    </ul>
@endsection
