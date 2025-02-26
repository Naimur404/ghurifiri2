@php
    $iconsReplace = [
        'whatsapp' => Theme::asset()->url('images/whatsapp-white.svg'),
        'telegram' => Theme::asset()->url('images/telegram-white.svg')
    ]
@endphp
<!--Widget social-->
<div class="sidebar-widget widget-social-network mb-30">
    <div class="widget-header position-relative mb-20 pb-10">
        <h5 class="widget-title mb-10">{{ !empty($config['title']) ? $config['title'] : __('Follow Us') }}</h5>
        <div class="bt-1 border-color-1"></div>
    </div>
    @php
        $socials = [];
        foreach (json_decode(theme_option('social_links'), true) as $socialLink) {
            if(!empty($socialLink[2]['value'])) {
            $socials[] = $socialLink;
            }
        }
    @endphp
    <div class="social-network">
        @foreach ($socials as $socialLink)
            @php $socialIcon = strtolower($socialLink[1]['value']) @endphp

            @if ($loop->index % 2 == 0)
                <div class="follow-us d-flex align-items-center">
                    @endif
                    <a class="follow-us-{{ $socialIcon }} clearfix  @if($loop->index % 2 == 0) mr-5 @else ml-5 @endif mb-10"
                       href="{{ $socialLink[2]['value'] }}" target="_blank">
                        <div class="social-icon">
                            @if( isset($iconsReplace[$socialIcon]))
                                <i class="ti-{{ $socialIcon }} mr-5 v-align-space">
                                    <img src="{{ $iconsReplace[$socialIcon] }}" width="20"
                                         alt="whatapps icon">
                                </i>
                                <i class="ti-{{ $socialIcon }} mr-5 v-align-space nth-2">
                                    <img src="{{ $iconsReplace[$socialIcon] }}" width="20"
                                         alt="whatapps icon">
                                </i>
                            @else
                                <i class="ti-{{ $socialIcon }} mr-5 v-align-space"></i>
                                <i class="ti-{{ $socialIcon }} mr-5 v-align-space nth-2"></i>
                            @endif
                        </div>
                        <span class="social-name">{{ $socialLink[0]['value'] }}</span>
                        @if(!empty($socialLink[3]['value']))
                            @if($socialLink[3]['value'] > 1000)
                                <span class="social-count counter-number">
                                    {{ (int)((int) $socialLink[3]['value']) / 1000 }}
                                </span>
                                <span class="social-count">K</span>
                            @else
                                <span class="social-count counter-number">{{ $socialLink[3]['value'] }}</span>
                            @endif
                        @endif
                    </a>

                    @if ($loop->index % 2 == 1 || count($socials) == $loop->index + 1)
                </div>
            @endif
        @endforeach
    </div>
</div>
