@extends("dashboard")

@section("content")
    Student Dashboard
@endsection

@section("table")
<!-- Success & Error Messages -->
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

<!-- HACK: Show modal if there are errors -->
@if($errors->any())
<script>
    window.addEventListener('DOMContentLoaded', function() {
        $('#addStudentModal').modal('show');
    });
</script>
@endif

<!-- Add Student Modal -->
<div class="modal" tabindex="-1" role="dialog" id="addStudentModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include("components.forms.add-student")
            </div>
        </div>
    </div>
</div>

<!-- Add Student Button -->
<button class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#addStudentModal">
    Add Student
</button>

<!-- Student Table -->
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Age</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->name}}</td>
            <td>{{$student->address}}</td>
            <td>{{$student->age}}</td>
            <td>
                <div class="d-flex">
                    <!-- Delete Button with Confirmation -->
                    <button type="button" class="btn btn-danger delete-btn" data-toggle="tooltip" title="Delete Student"
                        data-id="{{ $student->id }}">
                        <i class="fas fa-user-times"></i>
                    </button>

                    <!-- Edit Button -->
                    <a href="{{route('student.edit',$student->id)}}" class="ml-1 btn btn-primary" data-toggle="tooltip" title="Edit Student">
                        <i class="fas fa-user-edit"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this student?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();

        // Auto-dismiss alerts after 3 seconds
        setTimeout(() => {
            $(".alert").fadeOut("slow");
        }, 3000);

        // Delete Confirmation
        $('.delete-btn').on('click', function() {
            let studentId = $(this).data('id');
            let actionUrl = "{{ route('student.destroy', ':id') }}".replace(':id', studentId);
            $('#deleteForm').attr('action', actionUrl);
            $('#deleteConfirmationModal').modal('show');
        });
    });
</script>
@endpush
