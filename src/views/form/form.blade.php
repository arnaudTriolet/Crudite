<form action="{{ route($currentRouteName . "-save", ["id" => isset($item->id) ? $item->id : null]) }}" method="post" enctype='multipart/form-data'>
    <div class="pl-3 pr-3 pt-3 pb-3">
        @foreach ($config as $name => $fields)
            {{ CRUD::getEditField($name, $fields, $item) }}
        @endforeach
    </div>
    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
        <button type="submit" class='btn btn-primary'><i class="fa fa-check" aria-hidden="true"></i> Sauvegarder</button>
        <input type="hidden" name="crudite_form_name" value='{{ $form_name }}'>
    </div>
    @csrf
</form>