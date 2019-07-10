<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CG\Forms\FilledForm;

class testForm extends Controller
{
  public function create(Request $request)
  {
    $defaultBaseFormID = 1;

    $form = new FilledForm;
    $form->form_id = $defaultBaseFormID;
    $form->contents = json_decode('{}');
    $form->feedback = json_decode('{}');
    $form->owner = "testuser";
    $form->save();
    return json_decode($form, true);
  }

  public function delete(Request $request, $id)
  {
    if (FilledForm::where('id', $id)->count() != 0) {
      $form = FilledForm::where('id', $id);
      $form->delete();
      return "Form with id:" . $id . " deleted successfully";
    } else {
      return "Couldn't find form with id:" . $id;
    }
  }
}
