<?php

namespace ArnaudTriolet\Crudite\Controller;

use ArnaudTriolet\Crudite\Uploader;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    public $prefix = null;
    public $model = null;

    public function __construct()
    {
        if (is_null($this->prefix)) {
            throw new Exception("Please set \"prefix\" property in your controller");
        }
        
        if (is_null($this->model)) {
            throw new Exception("Please set \"model\" property in your controller");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->model::paginate(20);
        $data = [
            "model" => $this->model,
            "prefix" => $this->prefix,
            "name" => $this->name."s",
            "paginate" => $paginate
        ];
        return view($this->prefix . "/index", $data);
    }

    /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function table()
    {
        $paginate = $this->model::paginate(20);
        $data = [
            "model" => $this->model,
            "prefix" => $this->prefix,
            "name" => $this->name."s",
            "paginate" => $paginate
        ];
        return view($this->prefix . "/table", $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->prefix . "/create", [
            "model" => new $this->model
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formName = $request->input("crudite_form_name");
        $validationsRules = $this->_getFormValidationRule($formName);
        $details = $this->_getFormDetails($formName);
        // dd($formName, $request->all(), $validationsRules);
        $validator = Validator::make($request->all(), $validationsRules );
        $data = $validator->validate();
        
        $item = new $this->model;
        $item->fill($data);

        foreach ($details as $key => $value) {
            if (isset($value["type"]) && $value['type'] == "image") {
                if ($request->$key !== null) {
                    // dd($request->$key);
                    $url = Uploader::upload($request->$key, $key);
                    $item->$key = $url;
                }
            }
        }

        try {
            $item->save();
        } catch (\Throwable $th) {
            return $this->errorRedirect($request, "Désolé une erreur est survenue durant la sauvegarde");
        }

        return redirect()->back()->with("success", "L'élément a bien été ajouté");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->model::findOrFail($id);
        $data = [
            "model" => $this->model,
            "prefix" => $this->prefix,
            "name" => $this->name . "s",
            "item" => $item
        ];
        return view($this->prefix . "/show", $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->_getItem($id);
        return view($this->prefix . "/edit", [
            "item" => $item
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formName = $request->input("crudite_form_name");
        $validationsRules = $this->_getFormValidationRule($formName);
        $details = $this->_getFormDetails($formName);

        $validator = Validator::make($request->all(), $validationsRules);
        $data = $validator->validate();

        // $item = new $this->model;
        $item = $this->_getItem($id);
        $item->fill($data);

        foreach ($details as $key => $value) {
            if (isset($value["type"]) && $value['type'] == "image") {
                if ($request->$key !== null) {
                    $url = Uploader::upload($request->$key, $key);
                    $item->$key = $url;
                }
            }
        }
        // dd($item);
        try {
            $item->save();
        } catch (\Throwable $th) {
            return $this->errorRedirect($request, "Désolé une erreur est survenue durant la sauvegarde");
        }

        return redirect()->back()->with("success", "L'élément a bien été ajouté");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->_getItem($id);
        $item->delete();
        return redirect()->back()->with("success", "L'élément a été supprimé");
    }

    private function _getItem($id)
    {
        $item = $this->model::find($id);
        return $item;
    }

    private function _getFormDetails($name)
    {
        try {
            return (new $this->model)->forms[$name];
        } catch (\Throwable $th) {
            return null;
        }
    }

    private function _getFormValidationRule($name)
    {
        try {
            return (new $this->model)->validation[$name];
        } catch (\Throwable $th) {
            return null;
        }
    }
}
