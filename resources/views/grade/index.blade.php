@extends("dashboard")
@section("content")
    Grades Dashboard
@endsection

@section("table")

<!-- HACK: toggle the modal on refresh if there are any errors -->
@if($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            $('#addGradeModal').modal('show');
        });
    </script>
@endif

<!-- Success or Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Add Grade Modal -->
<div class="modal" tabindex="-1" role="dialog" id="addGradeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Add Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include("components.forms.add-grade") <!-- Include the form for adding a grade -->
            </div>
        </div>
    </div>
</div>

<!-- Add Button -->
<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addGradeModal">Add Grade</button>

<!-- Grades Table -->
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Subject Code</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($grades as $grade)
        <tr>
            <td>{{$grade->id}}</td>
            <td>{{$grade->student->name}}</td>
            <td>{{$grade->subject->subjectCode}}</td>
            <td>{{$grade->grade}}</td>
            <td>
                <div class="d-flex">

                    <!-- Delete Button -->
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteGradeModal" data-grade-id="{{ $grade->id }}" data-grade-name="{{ $grade->student->name }}" data-subject="{{ $grade->subject->subjectCode }}">
                        <i class="fas fa-user-times"></i>
                    </button>

                    <!-- Edit Button -->
                    <a href="{{ route('grade.edit', $grade->id) }}" class="ml-1 btn btn-primary" data-toggle="tooltip" title="Edit Grade">
                        <i class="fas fa-user-edit"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteGradeModal" tabindex="-1" role="dialog" aria-labelledby="deleteGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGradeModalLabel">Delete Grade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the grade for <strong id="grade-name"></strong> in the subject <strong id="subject-code"></strong>?
            </div>
            <div class="modal-footer">
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push("scripts")
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();

        // Set up delete modal with dynamic data
        $('#deleteGradeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var gradeId = button.data('grade-id');
            var gradeName = button.data('grade-name');
            var subjectCode = button.data('subject');
            
            // Set the modal content with dynamic data
            $('#grade-name').text(gradeName);
            $('#subject-code').text(subjectCode);
            
            var form = $(this).find('#delete-form');
            form.attr('action', '/grades/' + gradeId); // Set the action to the correct route
        });
    });
</script>
@endpush
