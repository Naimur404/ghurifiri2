@if (is_plugin_active('language'))
    @php
        $supportedLocales = Language::getSupportedLocales();
    @endphp
    @if ($supportedLocales && count($supportedLocales) > 1)
        @php
            $languageDisplay = setting('language_display', 'all');
        @endphp

        <div class="padtop10 mb-2 language">
            @if (setting('language_switcher_display', 'dropdown') == 'dropdown')
                <div id="langMenuDropdow" class="dropdown-menu dropdown-menu-left" aria-labelledby="langMenu">
                    @foreach ($supportedLocales as $localeCode => $properties)
                        @if ($localeCode != Language::getCurrentLocale())
                            <a class="dropdown-item" href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}">
                                {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                                {{ $properties['lang_name'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
                <a class="dropdown-toggle" href="#" role="button" id="langMenu" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="ti-world mr-5"></i>
                    <span>{{ Language::getCurrentLocaleName() }}</span>
                </a>
            @else
                @foreach ($supportedLocales as $localeCode => $properties)
                    @if ($localeCode != Language::getCurrentLocale())
                        <a class="{{ $color ?? '' }}" href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}">
                            @if (($languageDisplay == 'all' || $languageDisplay == 'flag')){!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}@endif
                            @if (($languageDisplay == 'all' || $languageDisplay == 'name'))
                                <span>{{ $properties['lang_name'] }}</span>@endif
                        </> &nbsp;
                    @endif
                @endforeach
            @endif
        </div>
    @endif
@endif
