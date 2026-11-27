@props(['bodyId' => null])
<div class="card-box overflow-hidden">
    <table class="table">
        <thead><tr>{{ $head }}</tr></thead>
        <tbody @if ($bodyId) id="{{ $bodyId }}" @endif>{{ $slot }}</tbody>
    </table>
</div>