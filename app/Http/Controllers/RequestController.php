<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CG\Forms\BaseForm;
use CG\Forms\FilledForm;
use CG\Forms\RenderableForm;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

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
    $data = array("count" => 0,
            "nameID" => -1,
            "dateID" => -1);
    $data = $this->getCountNameDate($baseJSON, $data);
    $empty = [];
    for ($i = 0; $i < $data['count']; $i++) {
      $empty["field-".$i] = "";
    }
    return $this->store($response,
                $id,
                $empty,
                $empty,
                $owner);
  }

  public function duplicate(Request $request)
  {
    $response = array(
      "msg" => "Success",
      "id" => "-1"
    );
    $filledID = Input::get('id');
    $filledForm = FilledForm::findOrFail($filledID);
    $baseJSON = BaseForm::findOrFail($filledForm->form_id)->json_data['fields'];
    $owner = Input::get('owner');
    if (trim($owner) == "") {
      $response['msg'] = "You must enter an owner";
      return $response;
    }
    return $this->store($response,
                $filledForm->form_id,
                $filledForm->contents,
                $filledForm->feedback,
                $owner);
  }

  private function store($response, $id, $contents, $feedback, $owner) {
    // Pass this to recursive-enabled function to get (count, nameID, dateID)
    $form = new FilledForm;
    $form->form_id = $id;
    $form->contents = $contents;
    $form->feedback = $feedback;
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
    $forms = FilledForm::all()->sortBy('id');
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

  public function delete(Request $request)
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




// THE FOLLOWING IS NOT MY WORK, IT IS FROM CG_APPRAISALS/FILLEDFORMCONTROLLER

  /**
* Builds a word document using PhpWord package.
* Saves as a word document but also returns document object so
*   download function can create other file types if the user requests it
* @param $id : id of filled form user wants to download
* @return phpWord object of file contents
*/
private function buildDocument($id) {
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $docSection = $phpWord->addSection();
    //get FilledForm for user entries
    $form = FilledForm::all()->where('id',$id)->first();
    $fields = $form->contents;
    //get BaseForm for fields and titles
    $baseForm = BaseForm::all()->where('id',$form->form_id)->first()->json_data['fields'];
    $baseFormName = BaseForm::all()->where('id',$form->form_id)->first()->name;
    //loop and merge so reads "Field name" \n "User entry"
    $collection = collect();
    foreach ($baseForm as $obj) {
        if (isset($obj['label'])) {
            $collection->push($obj['label']);
        }
        if (isset($obj['sections'])) {
            foreach ($obj['sections'] as $section) {
                foreach ($section['fields'] as $parts) {
                    if (isset($parts['label'])) {
                        $collection->push($parts['label']);
                    }
                    if (isset($parts['sections'])) {
                            // SECOND LOOP FOR NESTED: CAN ONLY MANAGE 2
                        foreach ($parts['sections'] as $section2) {
                            foreach ($section2['fields'] as $parts2) {
                                if (isset($parts2['label'])) {
                                    $collection->push($parts2['label']);
                                }
                                if (isset($parts2['sections'])) {
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $docSection->addText($baseFormName,
        array('name' => 'Tahoma', 'size' => 22));
    $docSection->addText($form->owner,
        array('name' => 'Tahoma', 'size' => 18));
    //Add fields to the document
    $index = 0;
    foreach ($fields as $field) {
        //Needed so avoid illegal character errors
        $docSection->addText(preg_replace("/[^a-zA-Z0-9 ():.,\/!?-]/","", $collection[$index]),
            array('name' => 'Tahoma', 'size' => 15));
        //If blank specify user left field blank
        if (is_null($field)) {
            $docSection->addText(
                'Blank',
                array('name' => 'Tahoma', 'size' => 10, 'italic' => true)
            );
        }
        else {
            $textlines = explode("</p>", $field);
    //Split lists (ordered and unordered)
    /**
    PSEUDOCODE FOR SPLITTING LISTS
    split <p> into lines
    for each line
        if line starts with ul
            for each li
        if line starts with ol
            for each li
        else
            add line
    */
            $phpWord->addNumberingStyle(
                'multilevel',
                array(
                    'type' => 'multilevel',
                    'levels' => array(
                        array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
                        array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
                    )
                )
            );
            foreach ($textlines as $line) {
        // split unordered lists
                if (Str::contains($line,'<ul>')) {
                    $items = explode("<li>", $field);
                    for($i = 1;$i<count($items);$i++){
                        $docSection->addListItem((string) strip_tags($items[$i]),
                            0, array('name' => 'Tahoma', 'size' => 10));
                    }
                }
        // split orderd lines
                elseif (Str::contains($line,'<ol>')) {
                    $items = explode("<li>", $field);
                    for($i = 1;$i<count($items);$i++){
                        $docSection->addListItem((string) strip_tags($items[$i]),
                            0, array('name' => 'Tahoma', 'size' => 10),'multilevel');
                    }
                }
        // add non-list line
                else {
                    $docSection->addText((string) strip_tags($line),
                        array('name' => 'Tahoma', 'size' => 10)
                    );
                }
            }
        }
        $index = $index + 1;
    }
    //create word document
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('PDR.docx');
    return ($phpWord);
  }
  /**
  * download a word, html or open document
  * @param $request : POST request specifying which document type to return
  * @param $id : id of FilledForm to download
  * @return download document in specified format.
  */
  public function download(Request $request) {
      $id = Input::get('id');
      $type = Input::get('type');
      $phpWord = $this->buildDocument($id);
      if ($type=="Word") {
          return response()->download(public_path('PDR.docx'));
      }
      if ($type=="HTML") {
          $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
          $objWriter->save('PDR.html');
          return response()->download(public_path('PDR.html'));
      }
      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
      $objWriter->save('PDR.odt');
      return response()->public_path('PDR.odt');
  }
}
