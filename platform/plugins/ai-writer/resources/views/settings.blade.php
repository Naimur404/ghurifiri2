<div class="flexbox-annotated-section">
    <div class="flexbox-annotated-section-annotation">
        <div class="annotated-section-title pd-all-20">
            <h2>{{ trans('plugins/ai-writer::settings.title') }}</h2>
        </div>
        <div class="annotated-section-description pd-all-20 p-none-t">
            <p class="color-note">{{ trans('plugins/ai-writer::settings.description') }}</p>
        </div>
    </div>

    <div class="flexbox-annotated-section-content">
        <div class="wrapper-content pd-all-20">
            <div class="form-group mb-3">
                <div class="form-group mb-3">
                    <label class="text-title-field">{{ trans('plugins/ai-writer::settings.openai_api_key') }}</label>
                    <input data-counter="120" type="text" class="next-input"
                           placeholder="{{ trans('plugins/ai-writer::settings.openai_api_key_placeholder') }}"
                           value="{{ setting('openai_api_key', '') }}" name="openai_api_key">
                    <span
                        class="help-ts">{{ trans('plugins/ai-writer::settings.openai_api_key_description') }}</span>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="form-group mb-3">
                    <label class="text-title-field">{{ trans('plugins/ai-writer::settings.limit_text') }}</label>
                    <input type="number" max="2048" placeholder="Max: 2048" class="next-input" value="{{ setting('openai_limit_text', 256) }}" name="openai_limit_text">
                </div>
            </div>
        </div>
    </div>
</div>
