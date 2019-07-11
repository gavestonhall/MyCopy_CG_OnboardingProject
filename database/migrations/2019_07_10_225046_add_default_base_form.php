<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use CG\Forms\BaseForm;

class AddDefaultBaseForm extends Migration
{

    /**
     * Run the migrations.
     * Adds the base form using json_data
     * @return void
     */
    public function up()
    {
      $json_string = '{
        "name": "Deployment Request",
        "variant": 1,
        "description": "Please provide the following details for your request to be considered.",
        "vid": 0,
        "fields": [
          {
            "type": "sections",
            "sections": [
              {
                "heading": "Application",
                "fields": [
                  {
                    "type": "field",
                    "label": "Application Name",
                    "field_placeholder": "Application Name"
                  },
                  {
                    "type": "field",
                    "label": "Release Version",
                    "field_placeholder": "Release Version"
                  },
                  {
                    "type": "combo",
                    "label": "Language/Framework",
                    "combo_options": ["Node JS", "Ruby On Rails", "PHP Laravel", "Other"]
                  },
                  {
                    "type": "combo",
                    "label": "Database System",
                    "combo_options": ["MySql", "Sqlite3", "Postgresql", "Other"]
                  }
                ]
              },
              {
                "heading": "Deployment",
                "fields": [
                  {
                    "type": "field",
                    "label": "Deployment Date",
                    "field_placeholder": "DD/MM/YYYY"
                  },
                  {
                    "type": "text",
                    "label": "Summary",
                    "description": "Give any relevant details about this request here, including any special requirements.",
                    "text_limit": "-1"
                  },
                  {
                    "type": "field",
                    "label": "Name of Requester",
                    "field_placeholder": "John Smith"
                  }
                ]
              }
            ]
          }
        ]
      }';
      $json_string = json_decode(trim(preg_replace('/\s\s+/', ' ', $json_string)), true); // Removes all '\n'
      $form = new BaseForm();
      $form->json_data = $json_string;
      $form->save();
    }

    /**
     * Reverse the migrations.
     * Removes all base forms
     * @return void
     */
    public function down()
    {
      BaseForm::all()->each->delete();
    }
}
