@extends("dashboard")

@section("content")
    Subject Dashboard
@endsection

@section("table")
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

<!-- Display modal on refresh if there are any errors -->
@if($errors->any())
<script>
    window.addEventListener('DOMContentLoaded', function() {
        $('#addSubjectModal').modal('show');
    });
</script>
@endif

<!-- Add Subject Modal -->
<div class="modal" tabindex="-1" role="dialog" id="addSubjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include("components.forms.add-subject") <!-- Include the form for adding a subject -->
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Button -->
<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addSubjectModal">Add Subject</button>

<!-- Subjects Table -->
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject Code</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subjects as $subject)
        <tr>
            <td>{{$subject->id}}</td>
            <td>{{$subject->subjectName}}</td>
            <td>{{$subject->subjectCode}}</td>
            <td>
                <div class="d-flex">
                    <!-- Delete Button with Modal Trigger -->
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteSubjectModal" data-id="{{$subject->id}}">
                        <i class="fas fa-user-times"></i>
                    </button>

                    <!-- Edit Button -->
                    <a href="{{route('subject.edit', $subject->id)}}" class="ml-1 btn btn-primary" data-toggle="tooltip" title="Edit Subject">
                        <i class="fas fa-user-edit"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Delete Confirmation Modal -->
<div class="modal" tabindex="-1" role="dialog" id="deleteSubjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this subject?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteSubjectForm">
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
    // Initialize DataTable for the subjects table
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    // Set up delete modal with correct subject data
    $('#deleteSubjectModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var subjectId = button.data('id');
        
        // Set the action of the form to the correct delete route
        var formAction = '/subject/' + subjectId;
        $(this).find('#deleteSubjectForm').attr('action', formAction);
    });
</script>
@endpush
