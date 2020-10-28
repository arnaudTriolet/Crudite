<table class="table table-striped table-crud table-auto">
    <thead>
        <tr>
            <th class='actions text-center'>
                @if (isset($model->actions_table["add"]))    
                <a href="{{ route($model->actions_table["add"]["route"]) }}" class="btn {{ $model->actions_table["add"]["class"] }}">
                    <i class="fa fa-{{ $model->actions_table["add"]["icon"] }}" aria-hidden="true"></i>
                </a>
                @endif
            </th>
            @foreach ($model->fields_table as $attr)
                <th>{{ $model->getFieldTitle($attr) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
            <tr>
                <td class='actions'>
                    @foreach ($model->actions_table as $name => $action)    
                        @if ($name !== "add")    
                            <a href="{{ route($action["route"], ["id" => $item->id]) }}" class="btn {{ $action["class"] }}" data-toggle="tooltip" data-placement="top" title="{{ $action["title"] }}">
                                <i class="fa fa-{{ $action["icon"] }}" aria-hidden="true"></i>
                            </a>
                        @endif
                    @endforeach
                </td>
                @foreach ($model->fields_table as $attr)
                    <td>{!! $model->getFieldDisplay($item, $attr) !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>