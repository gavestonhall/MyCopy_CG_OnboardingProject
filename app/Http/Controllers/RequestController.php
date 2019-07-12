<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CG\Forms\BaseForm;
use CG\Forms\FilledForm;
use CG\Forms\RenderableForm;
use Illuminate\Support\Facades\Input;

class RequestController extends Controller
{
  public function create()
  {
    $jsonText = '[{
      "field_id": "0",
      "type": "combo",
      "label": "Form Template",
      "content": {},
      "combo_options": '. (BaseForm::all()->map->json_data->map->name) .'
    },
    {
      "field_id": "1",
      "type": "field",
      "label": "Owner",
      "content": ""
    }]';
    $fields = json_decode(trim(preg_replace('/\s\s+/', ' ', $jsonText)), true); // Removes all '\n'
    //return $fields;
    return view('createForm')->with(compact('fields'));
  }

  public function new(Request $request)
  {
    $response = array(
      "msg" => "Success",
      "id" => "-1"
    );
    $formName = Input::get('id');
    $names = BaseForm::all()->map->json_data->map->name;
    $ids = BaseForm::all()->map->id;
    $id = -1;
    for ($i = 0; $i < count($ids); $i++) {
      if ($names[$i] == $formName) {
        $id = $ids[$i];
      }
    }
    if ($id == -1) {
      $response['msg'] = "You must choose a template";
      return $response;
    }
    $owner = Input::get('owner');
    if (trim($owner) == "") {
      $response['msg'] = "You must enter an owner";
      return $response;
    }
    // $base = BaseForm::findOrFail($id);
    // $fields = $base->getFieldCounter(); // RenderableForm has this
    //     return $response;
    // $empty = [];
    // for ($i = 0; $i < $fields; $i++) {
    //   array_push($empty, "field-".$i);
    // }
    $form = new FilledForm;
    $form->form_id = $id;
    $empty = array( // Cannot do just [] since field-0 required for name
      "field-0" => "",
      "field-1" => "",
      "field-2" => "",
      "field-3" => "",
      "field-4" => "",
      "field-5" => ""
    );
    $form->contents = $empty;
    $form->feedback = $empty;
    $form->owner = $owner;
    $form->save();
    $response['id'] = $form->id;

    return $response;
  }

  public function view($id)
  {
    $filledForm = FilledForm::findOrFail($id);
    $renderableForm = New RenderableForm($filledForm);
    return view('viewForm', ['form' => $renderableForm]);
  }

  public function index()
  {
    $forms = FilledForm::all();
    $contents = $forms->map->contents;
    $names = [];
    $dates = [];
    foreach ($contents as $content) {
      array_push($names, $content["field-0"]);
      array_push($dates, $content["field-4"]);
    }
    return view('index', ['forms' => $forms, 'names' => $names, 'dates' => $dates]);
  }

  public function deletePOST(Request $request)
  {
    $id = Input::get('id');
    $form = FilledForm::findOrFail($id);
    $form->delete();
    return "Success";
  }

  public function edit($id)
  {
    $filledForm = FilledForm::findOrFail($id);
    $renderableForm = New RenderableForm($filledForm);
    return view('editForm', ['form' => $renderableForm]);
  }

  public function editPOST(Request $request, $id)
  {
      if ($request->has(['feedback', 'form_contents'])) {
        error_log("contents received");
      } else {
        error_log("failed to find contents");
      }

      $filledForm = FilledForm::findOrFail($id);
      $filledForm->contents = $request->input('form_contents');
      $filledForm->feedback = $request->input('feedback');
      $filledForm->save();
      return "Successfully updated form contents";
  }
}
