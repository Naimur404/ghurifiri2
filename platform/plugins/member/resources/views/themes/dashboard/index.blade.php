@extends('plugins/member::themes.dashboard.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}

    @if (is_plugin_active('blog'))
        <div class="row row-cards mb-3">
            <div class="col-12 col-md-6 col-lg-4 dashboard-widget-item">
                <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none" style="background-color: rgb(66, 153, 225);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                            <div class="desc fw-medium">{{ trans('plugins/blog::member.published_posts') }}</div>
                            <div class="number fw-bolder">
                                {{ $user->posts()->where('status', Botble\Base\Enums\BaseStatusEnum::PUBLISHED)->count() }}
                            </div>
                        </div>
                        <div class="visual pb-5 ps-1 position-absolute end-0">
                            <x-core::icon name="ti ti-circle-check" class="me-n2" style="opacity: 0.1;" />
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 dashboard-widget-item">
                <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none bg-danger">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                            <div class="desc fw-medium">{{ trans('plugins/blog::member.pending_posts') }}</div>
                            <div class="number fw-bolder">
                                {{ $user->posts()->where('status', Botble\Base\Enums\BaseStatusEnum::PENDING)->count() }}
                            </div>
                        </div>
                        <div class="visual pb-5 ps-1 position-absolute end-0">
                            <x-core::icon name="ti ti-clock-hour-8" class="me-n2" style="opacity: 0.1;" />
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 dashboard-widget-item">
                <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none bg-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                            <div class="desc fw-medium">{{ trans('plugins/blog::member.draft_posts') }}</div>
                            <div class="number fw-bolder">
                                {{ $user->posts()->where('status', Botble\Base\Enums\BaseStatusEnum::DRAFT)->count() }}
                            </div>
                        </div>
                        <div class="visual pb-5 ps-1 position-absolute end-0">
                            <x-core::icon name="ti ti-notes" class="me-n2" style="opacity: 0.1;" />
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endif

    <activity-log-component></activity-log-component>
@stop
