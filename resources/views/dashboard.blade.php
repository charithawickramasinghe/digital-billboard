<x-layout title="Dashboard">
    <div class="content">

@php
    $count = Auth::user()->screen_count ?? 0;
@endphp

<div class="container py-4">
    <h3 class="mb-4">Billboard Screens</h3>

    <div class="row g-3">
        @for ($i = 1; $i <= $count; $i++)
            <div class="col-md-3">
                <a href="{{ url('/billboard/'.$i) }}" target="_blank"
                   class="btn btn-outline-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2 py-4">
                    <i class="bi bi-display fs-3"></i> 
                    <span class="fs-4">Screen {{ $i }}</span>
                </a>
            </div>
        @endfor
    </div>
</div>

    </div>
</x-layout>