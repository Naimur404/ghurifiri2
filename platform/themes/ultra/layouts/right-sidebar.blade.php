{!! Theme::partial('header') !!}
<main class="position-relative">
    <div class="main_content pb-50 pt-50">
        <div class="page-header page-header-style-1 text-center">
            <div class="container">
                <h1><span class="color2">{{ SeoHelper::getTitle() }}</span></h1>
                {!! Theme::partial('breadcrumbs') !!}
                <div class="bt-1 border-color-1 mt-30 mb-50"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    {!! Theme::content() !!}
                </div>
                <!--Right sidebar-->
                <div class="col-lg-4 col-md-12 col-sm-12 primary-sidebar sticky-sidebar">
                    <div class="widget-area pl-30">
                        {!! dynamic_sidebar('primary_sidebar') !!}
                    </div>
                </div>
                <!--End sidebar-->
            </div>
        </div>
    </div>
</main>
{!! Theme::partial('footer') !!}
