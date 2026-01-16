<div wire:ignore  class="mt-2">
    <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    <textarea id="{{$attributes->wire('model')->value}}" {{$attributes->wire('model')}} class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}"  placeholder="{{ $attributes['placeholder'] }}"></textarea>
    @error($attributes->wire('model')->value) <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

@push('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style type="text/css">
.dialogelfinder {
    z-index: 20000;
}

.note-group-select-from-files {
  display: none;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
$(window).on('load', function () {
    $("#{{$attributes->wire('model')->value}}").summernote({
        placeholder: '{{ $attributes['placeholder'] }}',
        dialogsInBody: true,
        tabsize: 3,
        height: @if($attributes['height']) {{$attributes['height']}} @else 200 @endif,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture',  'video']],
        ['view', ['fullscreen', 'codeview']],
        ],
        popover: {
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']],
                ['custom', ['imageAttributes']],
            ],
        },
        imageAttributes: {
            icon: '<i class="note-icon-pencil"/>',
            figureClass: 'figureClass',
            figcaptionClass: 'captionClass',
            captionText: 'Caption Goes Here.',
            manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
        },
        callbacks: {
            onChange: function(contents, $editable) {
                @this.set("{{ $attributes->wire('model')->value }}", contents);
            }
        }
    });
});

    window.addEventListener('editorUpdate', event => {
        $("#{{$attributes->wire('model')->value}}").summernote("code", $("#{{ $attributes->wire('model')->value }}").val());
    });

</script>
@endpush
