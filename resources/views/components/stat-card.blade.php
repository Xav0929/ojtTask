@props(['label', 'id'])
<div class="col-md-4">
    <div class="card-box p-3">
        <small>{{ $label }}</small>
        <div class="fs-3 fw-bold" id="{{ $id }}">-</div>
    </div>
</div>