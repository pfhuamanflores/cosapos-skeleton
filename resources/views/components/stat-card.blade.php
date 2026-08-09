@props(['label', 'value', 'icon', 'tone' => 'blue', 'trend' => null, 'caption' => null])
<article class="stat-card stat-{{ $tone }}">
    <div class="stat-card-top"><span class="stat-label">{{ $label }}</span><span class="stat-icon"><i class="bi {{ $icon }}"></i></span></div>
    <strong class="stat-value">{{ $value }}</strong>
    <div class="stat-meta">@if($trend)<span class="stat-trend"><i class="bi bi-arrow-up-right"></i>{{ $trend }}</span>@endif<span>{{ $caption }}</span></div>
</article>
