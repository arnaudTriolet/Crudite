<div class="form-group">
    <label for="{{ $name }}">{{$config["title"]}}</label>
    <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control  @error($name) is-invalid @enderror" aria-describedby="helpId" value='{{isset($item->$name) ? $item->$name : "" }}'>
    @if (isset($config["help"]))
        <small id="helpId" class="text-muted">{{ $config["help"] }}</small>
    @endif
</div>