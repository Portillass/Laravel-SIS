<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\GradeRequest;
use App\Http\Requests\GradeUpdateRequest;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pass the grades, students, and subjects to the view
        $grades = Grade::all();
        $students = Student::all();
        $subjects = Subject::all();

        return view('grade.index', compact('grades', 'students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        // Create new grade
        $grade = new Grade();
        $grade->student_id = $request->student_id;
        $grade->subject_id = $request->subject_id;
        $grade->grade = $request->grade;
        
        // Save grade and check result
        if ($grade->save()) {
            return redirect()->route("grade.index")->with('success', 'Grade added successfully!');
        } else {
            return redirect()->route("grade.index")->with('error', 'Grade addition failed.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return view("grade.edit", compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeUpdateRequest $request, Grade $grade)
    {
        // Update grade
        $grade->grade = $request->grade;

        if ($grade->save()) {
            return redirect()->route("grade.index")->with('success', 'Grade updated successfully!');
        } else {
            return redirect()->route("grade.index")->with('error', 'Grade update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        // Delete grade
        if ($grade->delete()) {
            return redirect()->route("grade.index")->with('success', 'Grade deleted successfully!');
        } else {
            return redirect()->route("grade.index")->with('error', 'Grade deletion failed.');
        }
    }
}
