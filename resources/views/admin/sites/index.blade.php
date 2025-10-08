@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Сайты</h1>
        <a href="{{ route('admin.sites.create') }}" class="btn btn-primary">Добавить сайт</a>
        <table class="table mt-3">
            <thead>
            <tr><th>#</th><th>Наименование</th><th>Домен</th><th>Токкен</th><th>Действия</th></tr>
            </thead>
            <tbody>
            @foreach($sites as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->domain }}</td>
                    <td><code>{{ $s->token }}</code></td>
                    <td><a href="{{ route('admin.sites.view', $s->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
