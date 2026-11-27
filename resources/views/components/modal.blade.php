@props(['id', 'title' => null, 'titleId' => null, 'size' => '', 'form' => null, 'bodyClass' => ''])
<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered {{ $size }}">
        <div class="modal-content">
            @if ($form)<form id="{{ $form }}" novalidate>@endif
                @if ($title)
                    <div class="modal-header">
                        <h5 class="modal-title" @if ($titleId) id="{{ $titleId }}" @endif>{{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                @endif
                <div class="modal-body {{ $bodyClass }}">{{ $slot }}</div>
                @isset($footer)
                    <div class="modal-footer">{{ $footer }}</div>
                @endisset
            @if ($form)</form>@endif
        </div>
    </div>
</div>