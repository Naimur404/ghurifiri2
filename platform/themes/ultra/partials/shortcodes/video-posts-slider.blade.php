<div class="widgets-post-carausel-1 pt-40 mb-40">
    <div class="container">
        <div class="post-carausel-1 border-radius-10 bg-white">
            <div class="row no-gutters">
                <div class="col col-md-12">
                    <div class="post-carausel-1-items row" data-number-slide="5">
                        @foreach ($posts as $post)
                            {!! Theme::partial('components.post-card-editor-picked', ['post' => $post]) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
