<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LowSubjectController extends Controller
{
    public function index()
    {
        $lowSubjects = LowSubject::all();
        return view('low_subjects.index', compact('lowSubjects'));
    }

    public function create()
    {
        return view('low_subjects.create');
    }

    public function store(Request $request)
    {
        LowSubject::create($request->all());
        return redirect()->route('low_subjects.index')->with('success', 'Low subject created successfully');
    }

    public function edit($id)
    {
        $lowSubject = LowSubject::findOrFail($id);
        return view('low_subjects.edit', compact('lowSubject'));
    }

    public function update(Request $request, $id)
    {
        $lowSubject = LowSubject::findOrFail($id);
        $lowSubject->update($request->all());
        return redirect()->route('low_subjects.index')->with('success', 'Low subject updated successfully');
    }

    public function destroy($id)
    {
        LowSubject::findOrFail($id)->delete();
        return redirect()->route('low_subjects.index')->with('success', 'Low subject deleted successfully');
    }
}
