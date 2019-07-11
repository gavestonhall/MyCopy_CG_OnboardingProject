<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = \App\Request::all();

        return view('requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Request $request)
    {

        request()->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);

        $request::create([
            'name' => request('name'),
            'description' => request('description')
        ]);

        // $request = new \App\Request();
        // $request->name = request('name');
        // $request->description = request('description');
        // $request->save();

        return redirect('/requests');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Request $request)
    {
        // $request = \App\Request::findOrFail($id);

        return view('requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Request $request)
    {
        // $request = \App\Request::findOrFail($id);

        return view('requests.edit', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Request $request)
    {

        request()->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);


        $request->update(request(['name', 'description']));


        // $request = \App\Request::findOrFail($id);
        // $request->name = request('name');
        // $request->description = request('description');
        // $request->save();

        return redirect('/requests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Request $request)
    {
        $request->delete();

        return redirect('/requests');
    }

    /**
     * Duplicate and save a specific request
     * to the requests table.
     * @param int $id
     * @return \Illuminate\Http\Request
     */
    public function duplicate(int $id)
    {
        $request = new \App\Request;
        $request->findOrFail($id)->replicate()->save();

        return redirect('/requests');
    }

    /**
     * Creates a word document for the requested user
     * and downloads it onto their system.
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function downloadWordDocument(int $id)
    {
        $request = \App\Request::findOrFail($id);
        $document = new \PhpOffice\PhpWord\PhpWord();
        $section = $document->addSection();
        $text = $section->addText('ID: ' . $request->id);
        $text = $section->addText('Name: ' . $request->name);
        $text = $section->addText('Description: ' . $request->description);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save('downloads/' . $request->name . '.docx');

        return response()->download(public_path('downloads/' . $request->name . '.docx'));
    }
}
