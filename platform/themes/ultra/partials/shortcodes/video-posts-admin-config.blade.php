<div class="form-group mb-3">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="Latest videos">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Sub title') }}</label>
    <input name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control"
           placeholder="In movation">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Limit') }}</label>
    <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit', 7) }}" class="form-control"/>
</div>

<div class="form-group mb-3">
    <input name="is_slider"
           {{ Arr::get($attributes, 'is_slider', false) ? 'checked' : '' }} type="checkbox"
           value="1">
    <label class="control-label">{{ __('Is slider') }}</label>
</div>
