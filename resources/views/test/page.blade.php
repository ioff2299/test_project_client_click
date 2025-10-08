<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $site->name }}</title>
    <script>
        window.CLICKMAP_SITE_TOKEN = "{{ $site->token }}";
        window.CLICKMAP_API_URL = "{{ url('/capture-click') }}";
    </script>
    <script src="/js/click-tracker.js" defer></script>
</head>
<body>
<h1>{{ $site->name }}</h1>
<p>Кликайте по элементам на странице — они будут отправляться в админку.</p>
<button>Нажми меня</button>
<div class="box" style="width:150px;height:150px;background:lightblue;margin:20px;"></div>
</body>
</html>
