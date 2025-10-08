@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Добавление сайта</h1>
        <form method="POST" action="{{ route('admin.sites.store') }}">
            @csrf
            <div class="mb-3">
                <label>Наименование</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Домен</label>
                <input type="text" name="domain" class="form-control" required>
            </div>
            <button class="btn btn-success">Сохранить</button>
        </form>
    </div>
@endsection
