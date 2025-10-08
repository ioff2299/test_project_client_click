@extends('layouts.app')

@section('title', "Аналитика: {$site->name}")

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $site->name }}</h1>
        <a href="{{ route('admin.sites') }}" class="btn btn-outline-secondary">← Назад</a>
    </div>

    <ul class="nav nav-tabs mb-4" id="analyticsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="heatmap-tab" data-bs-toggle="tab" data-bs-target="#heatmap"
                    type="button" role="tab">Тепловая карта</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity"
                    type="button" role="tab">Активность по часам</button>
        </li>
    </ul>

    <div class="tab-content" id="analyticsTabsContent">
        {{-- ТЕПЛОВАЯ КАРТА --}}
        <div class="tab-pane fade show active" id="heatmap" role="tabpanel">
            <div class="card p-3">
                <h5>Карта кликов</h5>
                <div id="heatmapContainer" class="border mt-3" style="position:relative; width:100%; height:600px; overflow:hidden;">
                    <div id="heatmapCanvas" style="width:100%; height:100%;"></div>
                </div>
                <small class="text-muted d-block mt-2">
                    На тепловой карте видно, где пользователи чаще всего кликают на сайте.
                </small>
            </div>
        </div>

        {{-- ГРАФИК АКТИВНОСТИ --}}
        <div class="tab-pane fade" id="activity" role="tabpanel">
            <div class="card p-3">
                <h5>Активность по часам</h5>
                <canvas id="clickActivityChart" height="150"></canvas>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/heatmap.js/2.0.2/heatmap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const clicks = @json($clicksJson);

        // === Heatmap ===
        const heatmapContainer = document.getElementById('heatmapCanvas');
        if (heatmapContainer) {
            const heatmap = h337.create({
                container: heatmapContainer,
                radius: 40,
                maxOpacity: 0.6,
                blur: 0.9
            });

            const containerRect = heatmapContainer.getBoundingClientRect();
            clicks.forEach(c => {
                if (c.pct_x != null && c.pct_y != null) {
                    heatmap.addData({
                        x: c.pct_x * containerRect.width,
                        y: c.pct_y * containerRect.height,
                        value: 1
                    });
                }
            });
        }

        // === График активности ===
        const ctx = document.getElementById('clickActivityChart')?.getContext('2d');
        if (ctx) {
            const clicksByHour = Array(24).fill(0);
            clicks.forEach(c => {
                if (c.clicked_at) {
                    const hour = new Date(c.clicked_at).getHours();
                    clicksByHour[hour]++;
                }
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Array.from({length: 24}, (_, i) => `${i}:00`),
                    datasets: [{
                        label: 'Количество кликов',
                        data: clicksByHour,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    });
</script>
