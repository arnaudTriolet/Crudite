<div class="form-group">
    <label for="{{ $name }}">{{$config["title"]}}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" class="form-control wysiwyg @error($name) is-invalid @enderror" aria-describedby="helpId">{{isset($item->$name) ? $item->$name : ""}}</textarea>
    @if (isset($config["help"]))
        <small id="helpId" class="text-muted">{{ $config["help"] }}</small>
    @endif
</div>