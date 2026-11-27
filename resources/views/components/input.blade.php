@props(['label', 'name', 'type' => 'text', 'rows' => 3])
<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    @if ($type === 'textarea')
        <textarea name="{{ $name }}" rows="{{ $rows }}" {{ $attributes->merge(['class' => 'form-control']) }}></textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }}>
    @endif
    <div class="invalid-feedback" data-error="{{ $name }}"></div>
</div>