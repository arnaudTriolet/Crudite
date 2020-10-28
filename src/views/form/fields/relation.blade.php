@php
    $model = (new $settings["model"]);
    $list = $model::all();
@endphp
<div class="form-group">
    <label for="{{ $name }}">{{$config["title"]}}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="select2 form-control  @error($name) is-invalid @enderror" aria-describedby="helpId">
        @foreach ($list as $obj)
            <option value="{{$obj->id}}" @if($obj->id == $item->$name) selected @endif>
                {{$obj->getTitle()}}
            </option>
        @endforeach
    </select>
    @if (isset($config["help"]))
        <small id="helpId" class="text-muted">{{ $config["help"] }}</small>
    @endif
</div>