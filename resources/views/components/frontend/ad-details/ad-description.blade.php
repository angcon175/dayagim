<div>
    <div class="product-item__description">
        <h2 class="text--body-1-600">{{ __('descriptions') }}</h2>
        {!! $description !!}
    </div>
    @if(!$features->isEmpty())
    <div class="product-item__feature">
        <h2 class="text--body-1-600">{{ __('feature') }}</h2>
        {{-- {{ $features }} --}}
        <ul class="feature">
            <li>
                <ul>
                    @if($features)
                        @foreach ($features as $key => $feature)
                            @if ($loop->odd)
                                <li class="feature-item">
                                    <span class="icon">
                                        <x-svg.check-icon width="24" height="24" stroke="#00AAFF" />
                                    </span>
                                    <p class="text--body-3">{{ $feature->name }}</p>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </li>
            <li>
                <ul>
                    @if($features)
                        @foreach ($features as $key => $feature)
                            @if ($loop->even)
                                <li class="feature-item">
                                    <span class="icon">
                                        <x-svg.check-icon width="24" height="24" stroke="#00AAFF" />
                                    </span>
                                    <p class="text--body-3">{{ $feature->name }}</p>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
    </div>
    @endif
</div>
