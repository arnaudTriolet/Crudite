<div class="form-group">
    <label for="{{ $name }}">{{$config["title"]}}</label>
    <div class="input-group">
        <input type="datetime" name="{{ $name }}" id="{{ $name }}" class="form-control @error($name) is-invalid @enderror" aria-describedby="helpId" value='{{isset($item->$name) ? $item->$name : "" }}'>
    </div>
    @if (isset($config["help"]))
        <small id="helpId" class="text-muted">{{ $config["help"] }}</small>
    @endif
</div>