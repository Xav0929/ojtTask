@props(['label', 'name'])
<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" {{ $attributes->merge(['class' => 'form-select']) }}>{{ $slot }}</select>
    <div class="invalid-feedback" data-error="{{ $name }}"></div>
</div>