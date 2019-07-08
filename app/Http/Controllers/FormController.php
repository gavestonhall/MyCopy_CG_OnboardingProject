<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use CG\Forms\FilledForm;

class FormController extends Controller
{

	public function index()
	{
		return view('forms.index', ['forms' => FilledForm::all()]);
	}
}


