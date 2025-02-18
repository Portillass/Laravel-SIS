<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use App\Http\Requests\SubjectUpdateRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view("subject.index", ["subjects" => $subjects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the create view (optional if you have a separate create form)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        // Create new Subject instance and save data
        $subject = new Subject();
        $subject->subjectName = $request->subjectName;
        $subject->subjectCode = $request->subjectCode;
        $res = $subject->save();

        // Return success or error response
        if ($res) {
            return redirect()->route("subject.index")->with("success", "Subject added successfully!");
        } else {
            return redirect()->route("subject.index")->with("error", "Failed to add subject.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        // Return the edit view with the specific subject data
        return view("subject.edit", ["subject" => $subject]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectUpdateRequest $request, Subject $subject)
    {
        // Update subject details
        $subject->subjectName = $request->subjectName;
        $subject->subjectCode = $request->subjectCode;
        $res = $subject->save();

        // Return success or error response
        if ($res) {
            return redirect()->route("subject.index")->with("success", "Subject updated successfully!");
        } else {
            return redirect()->route("subject.index")->with("error", "Failed to update subject.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Delete the subject
        $res = $subject->delete();

        // Return success or error response
        if ($res) {
            return redirect()->route("subject.index")->with("success", "Subject deleted successfully!");
        } else {
            return redirect()->route("subject.index")->with("error", "Failed to delete subject.");
        }
    }
}
