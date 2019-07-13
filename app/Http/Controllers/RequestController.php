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
    $baseJSON = BaseForm::findOrFail($id)->json_data['fields'];
    // Pass this to recursive-enabled function to get (count, nameID, dateID)
    $data = array("count" => 0,
            "nameID" => -1,
            "dateID" => -1);
    $data = $this->getCountNameDate($baseJSON, $data);
    $empty = [];
    for ($i = 0; $i < $data['count']; $i++) {
      $empty["field-".$i] = "";
    }
    $form = new FilledForm;
    $form->form_id = $id;
    $form->contents = $empty;
    $form->feedback = $empty;
    $form->owner = $owner;
    $form->save();
    $response['id'] = $form->id;

    return $response;
  }

  private function getCountNameDate($fields, $input) {
    $output = $input;
    foreach ($fields as $field) {
      if ($field['type'] == 'sections') {
        foreach ($field['sections'] as $section) {
          $output = $this->getCountNameDate($section['fields'], $output);
        }
      } else {
        if (strtolower($field['label']) == 'app name' || strtolower($field['label']) == 'application name') {
          $output['nameID'] = $output['count'];
        } elseif (strtolower($field['label']) == 'deploy date' || strtolower($field['label']) == 'deployment date') {
          $output['dateID'] = $output['count'];
        }
        $output['count']++;
      }
    }
    return $output;
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
    // For each filled form, find the name and date ID using base form id
    $names = [];
    $dates = [];
    $mappings = [];
    $index = 0;
    foreach ($contents as $content) {
      // check if form_id already in mappings, otherwise do this
      $data = array("count" => 0,
              "nameID" => -1,
              "dateID" => -1);
      if (array_key_exists($forms[$index]->form_id, $mappings)) {
        $data = $mappings[$forms[$index]->form_id];
      } else {
        // get form_id from $forms and save nameID + dateID to array
        $baseJSON = BaseForm::findOrFail($forms[$index]->form_id)->json_data['fields'];
        $data = $this->getCountNameDate($baseJSON, $data);
        $mappings[$forms[$index]->form_id] = $data;
      }
      $index++;
      array_push($names, $content["field-".$data['nameID']]);
      array_push($dates, $content["field-".$data['dateID']]);
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
