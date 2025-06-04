@php use Carbon\Carbon; @endphp
<div class="card bg-body-tertiary rounded-4">
    <div class="card-body p-4">
        <div class="row align-items-start">
            <div class="col">
                <h4 class="fs-5 fw-normal text-body-secondary mb-1">
                    {{ $title }}
                </h4>
                <div class="mt-2">
                    <table class="table">
                        <thead>
                            <tr>
                                @foreach($headers as $header)
                                    <th scope="col">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tableData as $item)
                                <tr>
                                    @foreach ($columns as $column)
                                        @if ($loop->first)
                                            <th scope="row">
                                        @else
                                            <td>
                                        @endif

                                        @if (isset($column['type']))
                                            @switch ($column['type'])
                                                @case ('link')
                                                    <a href="{{ route($column['route'], $item[$column['route_param']]) }}"
                                                       class="fw-bold text-decoration-none link-primary link-opacity-50-hover">
                                                        {{ $item[$column['field']] }}
                                                    </a>
                                                    @break
                                                @case ('date')
                                                    <span class="fs-sm text-body-secondary">
                                                        {{ Carbon::parse($item[$column['field']])->format($column['format'] ?? 'd.m.Y, H:i') }}
                                                    </span>
                                                    @break
                                                @case ('counter')
                                                    {{ $loop->parent->iteration }}
                                                    @break
                                                @case('custom')
                                                    {!! $column['template']($item) !!}
                                                    @break
                                                @default
                                                    {{ $item[$column['field']] }}
                                            @endswitch
                                        @else
                                            {{ $item[$column['field']] }}
                                        @endif

                                        @if($loop->first)
                                            </th>
                                        @else
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($headers) }}" class="text-center text-muted">
                                        {{ __('dashboard.no_data_available') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
