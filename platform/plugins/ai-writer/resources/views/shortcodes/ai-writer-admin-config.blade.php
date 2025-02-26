@php
    $btnCLickId = 'getAIContent' . time();
@endphp
<div class="form-group">
    <label class="control-label text-capitalize">{{ trans('plugins/ai-writer::shortcode.primary-keyword') }}</label>
    <input id="aiKeyword" class="form-control" value=""
           placeholder="{{ trans('plugins/ai-writer::shortcode.primary-keyword-placeholder') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ trans('plugins/ai-writer::shortcode.choose-your-key') }}</label>
    {!! Form::select('',get_ai_writer_subjects(), '', ['id' => 'aiType', 'class' => 'form-control']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">{{ trans('plugins/ai-writer::shortcode.number-of-variants') }}</label>
            {!! Form::select('', [
                '1' => '1 Variants',
                '2' => '2 Variants',
                '3' => '3 Variants',
        ], '', ['id' => 'aiVariant', 'class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">{{ trans('plugins/ai-writer::shortcode.language') }}</label>
            {!! Form::select('', $activeLanguages, '', ['id' => 'aiLanguage', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group text-center">
    <button class="btn btn-danger btn-get-ai-content" type="button"
            id="{{ $btnCLickId }}">{{ trans('plugins/ai-writer::shortcode.btn-get-content') }}</button>
</div>

<style>
    .short_code_modal .modal-footer {
        display: none;
    }
</style>

<script>
    "use strict";
    $(function () {
        function nl2br(str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        $('body').on('click', '#{{ $btnCLickId }}', function (e) {
            if ($('#aiKeyword').val() == '' || $('#aiKeyword').val() === undefined) {
                Botble.showError("Keyword is required");
                return;
            }

            $.ajax({
                url: '{{ url('/ajax/get-ai-content') }}',
                type: 'POST',
                cache: false,
                data: {
                    'keyword': $('#aiKeyword').val(),
                    'type': $('#aiType').val(),
                    'variant': $('#aiVariant').val(),
                    'language': $('#aiLanguage').val(),
                },
                beforeSend: function () {
                    let html = '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i> ' + $('.btn-get-ai-content').html();
                    $('.btn-get-ai-content').prop('disabled', true).html(html);
                },
                success: res => {
                    window.EDITOR.CKEDITOR['content'].insertHtml(nl2br(res.data.content, true));
                    $('.btn-get-ai-content').find('i').remove();
                    $('.btn-get-ai-content').prop('disabled', false);
                    $('#shortcode-modal').modal('hide');
                },
                error: res => {
                    Botble.handleError(res);
                    $('.btn-get-ai-content').find('i').remove();
                    $('.btn-get-ai-content').prop('disabled', false);
                }
            });
        })
    })
</script>
