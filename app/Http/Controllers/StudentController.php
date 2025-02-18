<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view("student.index", ["students" => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->address = $request->address;
        $student->age = $request->age;
        $res = $student->save();

        if ($res) {
            return redirect()->route('student.index')->with("success", "Student added successfully!");
        } else {
            return redirect()->route('student.index')->with("error", "Error adding student!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view("student.edit", ["student" => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUpdateRequest $request, Student $student)
    {
        $student->name = $request->name;
        $student->address = $request->address;
        $student->age = $request->age;
        $res = $student->save();

        if ($res) {
            return redirect()->route("student.index")->with("success", "Student updated successfully!");
        } else {
            return redirect()->route("student.index")->with("error", "Student update failed!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $res = $student->delete();

        if ($res) {
            return redirect()->route("student.index")->with("success", "Student deleted successfully!");
        } else {
            return redirect()->route("student.index")->with("error", "Student deletion failed!");
        }
    }
}
