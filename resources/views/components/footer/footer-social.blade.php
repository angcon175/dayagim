<ul class="social-icon">
    <!-- facebook -->
    @if (isset($settings->facebook))
        <li class="social-icon__item">
            <a href="{{ $settings->facebook }}" class="social-icon__link">
                <x-svg.facebook-icon fill="currentColor" />
            </a>
        </li>
    @endif

    <!-- Twitter -->
    @if (isset($settings->twitter))
        <li class="social-icon__item">
            <a href="{{ $settings->twitter }}" class="social-icon__link">
                <x-svg.twitter-icon fill="currentColor" />
            </a>
        </li>
    @endif

    <!-- Instagram -->
    @if (isset($settings->instagram))
        <li class="social-icon__item">
            <a href="{{ $settings->instagram }}" class="social-icon__link">
                <x-svg.instagram-icon />
            </a>
        </li>
    @endif

    <!-- Youtube -->
    @if (isset($settings->youtube))
        <li class="social-icon__item">
            <a href="{{ $settings->youtube }}" class="social-icon__link">
                <x-svg.youtube-icon />
            </a>
        </li>
    @endif

    <!-- Linkedin -->
    @if (isset($settings->linkedin))
        <li class="social-icon__item">
            <a href="{{ $settings->linkedin }}" class="social-icon__link">
                <x-svg.linkedin-footer-icon />
            </a>
        </li>
    @endif

    <!-- whats app -->
    @if (isset($settings->whatsapp))
        <li class="social-icon__item">
            <a href="{{ $settings->whatsapp }}" class="social-icon__link">
                <x-svg.whatsapp-footer-icon />
            </a>
        </li>
    @endif
</ul>
