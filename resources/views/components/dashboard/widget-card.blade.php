<div class="card bg-body-tertiary rounded-4">
    <div class="card-body p-4">
        <div class="row align-items-start">
            <div class="col">
                <h4 class="fs-5 fw-normal text-body-secondary mb-1">
                    {{ $title }}
                </h4>
                <span class="fs-6 text-secondary">{{ $subtitle }}</span>
                <div class="fs-3 fw-semibold mt-2">
                    {{ $value }}
                </div>
            </div>
            <div class="col-auto">
                @php
                    $colorVariable = '--bs-' . $color . '-bg-subtle';
                @endphp
                <div class="avatar avatar-lg" style="--bs-avatar-bg: var({{ $colorVariable }})">
                    <x-icon name="{{ $icon }}" size="3" color="{{ $color }}"></x-icon>
                </div>
            </div>
        </div>
    </div>
</div>
