<div class="form-group">
    <label for="{{ $name }}">{{$config["title"]}}</label>
    <div class="row">
        <div class="col-sm-8">
            <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control  @error($name) is-invalid @enderror" aria-describedby="helpId">
        </div>
        <div class="col-sm-4">
            @if (isset($item->$name) && !empty($item->$name))
                <img src="{{$item->$name}}" alt="{{$item->$name}}">
            @endif
        </div>
    </div>

    @if (isset($config["help"]))
        <small id="helpId" class="text-muted">{{ $config["help"] }}</small>
    @endif
</div>