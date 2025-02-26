<div class="d-flex">
    <div
        class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
        <a href="{{ get_external_link($post) }}" {{ is_external_link($post) ? 'target="_blank"' : '' }}>
            <img src="{{ RvMedia::getImageUrl($post->image, 'thumb', false, RvMedia::getDefaultImage()) }}" @if(isset($height)) height="{{ $height }}" @endif alt="{{ $post->name }}">
        </a>
        @if(is_video_post($post))
            <div class="play_btn play_btn_small">
                <a class="play-video" href="{{ get_external_link($post) }}" {{ is_external_link($post) ? 'target="_blank"' : '' }}>
                    <i class="ti-control-play"></i>
                </a>
            </div>
        @endif
        @if(is_external_link($post))
            <span class="top-right-icon background10"><i class="ti-link" aria-hidden="true"></i></span>
        @endif
    </div>
    <div class="post-content media-body">
        <div class="entry-meta meta-0 mb-10">
            @php $category = $post->categories->first(); @endphp
            @if ($category)
                <a href="{{ $category->url }}">
                    <span class="post-in {{ random_background() }} color-white font-small">{{ $category->name }}</span>
                </a>
            @endif
        </div>
        <h6 class="post-title mb-10 text-limit-2-row"><a href="{{ get_external_link($post) }}" {{ is_external_link($post) ? 'target="_blank"' : '' }}>{{ $post->name }}</a></h6>
        <div class="entry-meta meta-1 font-x-small color-grey d-flex">
            <span class="post-on">{{ $post->created_at->format(post_date_format()) }}</span>
            <span class="hit-count"><i class="ti-bolt"></i>{{ number_format($post->views) . ' ' . __('views') }}</span>
        </div>
    </div>
</div>
