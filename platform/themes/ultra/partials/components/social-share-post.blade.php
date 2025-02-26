<li class="list-inline-item">
    <a class="social-icon facebook-icon text-xs-center color-white"
       href="javascript:void(0)"
       onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ urlencode(get_external_link($post)) }}&title={{ $post->description }}', 'Share This Post', 'width=640,height=450'); return false">
        <i class="ti-facebook"></i>
    </a>
</li>
<li class="list-inline-item">
    <a class="social-icon twitter-icon text-xs-center color-white"
       href="javascript:void(0)"
       onclick="window.open('https://twitter.com/intent/tweet?url={{ urlencode(get_external_link($post)) }}&text={{ $post->description }}', 'Share This Post', 'width=640,height=450'); return false">
        <i class="ti-twitter-alt"></i>
    </a>
</li>
<li class="list-inline-item">
    <a class="social-icon instagram-icon text-xs-center color-white"
       href="javascript:void(0)"
       onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(get_external_link($post)) }}&summary={{ rawurldecode($post->description) }}', 'Share This Post', 'width=640,height=450'); return false">
        <i class="ti-linkedin"></i>
    </a>
</li>
<li class="list-inline-item">
    <a class="social-icon pinterest-icon text-xs-center color-white"
       href="javascript:void(0)"
       onclick="window.open('http://pinterest.com/pin/create/button/?url={{ urlencode(get_external_link($post)) }}&summary={{ rawurldecode($post->description) }}', 'Share This Post', 'width=640,height=450'); return false">
        <i class="ti-pinterest"></i>
    </a>
</li>
<li class="list-inline-item">
    <a class="social-icon whatsapp-icon text-xs-center color-white"
       href="javascript:void(0)"
       onclick="window.open('https://api.whatsapp.com/send?text={{ rawurlencode($post->description . ' ' . get_external_link($post)) }}', 'Share This Post', 'width=640,height=450'); return false">
        <img src="{{ Theme::asset()->url('images/whatsapp-white.svg') }}" alt="WhatsApp" width="16" height="16">
    </a>
</li>
