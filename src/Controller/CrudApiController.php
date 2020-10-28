<?php

namespace ArnaudTriolet\Crudite\Controller;

use ArnaudTriolet\Crudite\Uploader;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudApiController extends Controller
{
    public $model = null;

    public function __construct()
    {
        if (is_null($this->model)) {
            throw new Exception("Please set \"model\" property in your controller");
        }
    }

    /**
     * return all items.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $all = $this->model::all();
        
        return $all;
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
        $validator = Validator::make($request->all(), $validationsRules);
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
    public function item($id)
    {
        $item = $this->model::findOrFail($id);
        return $item;
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
}
