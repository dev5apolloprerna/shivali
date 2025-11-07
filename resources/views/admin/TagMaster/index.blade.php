@extends('layouts.app')

@section('title', 'TagMaster')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <!-- Left side - Add Form -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add Tag</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('TageMaster.store') }}" id="categoryForm"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="BannerImage" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            maxlength="50">
                                    </div>

                                    <div class="d-flex ">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-light">Clear</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Listing -->
                    <div class="col-lg-8">
                        <div class="card">
                            {{-- <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Banner Listing</h4>
                                <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete All
                                </button>
                            </div> --}}
                            <div class="card-body">
                                <!-- <form method="POST" id="bulkDeleteForm" action="{{ route('admin.category.bulk-delete') }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @csrf -->
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            {{-- <th>
                                                <input type="checkbox" id="selectAll">
                                            </th> --}}
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($TagMaster as $Tag)
                                            <tr>
                                                {{-- <td>
                                                    <input type="checkbox" name="ids[]"
                                                        value="{{ $category->iCategoryId }}">
                                                </td> --}}
                                                <td>
                                                    {{ $Tag->Name ?? '' }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                        data-id="{{ $Tag->id }}" data-name="{{ $Tag->Name }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('TageMaster.delete', $Tag->id) }}"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- </form> -->

                                {{ $TagMaster->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- page-content -->
    </div> <!-- main-content -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editTagmasterModal" tabindex="-1" aria-labelledby="editTagmasterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editTagmasterForm" enctype="multipart/form-data" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit TagMaster</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="edittagmasterId">


                        <div class="mb-3">
                            <label for="editStrname" class="form-label">Name <span class="text-danger">*</span></label>
                            <!-- Change this to a file input -->
                            <input type="text" class="form-control" id="editStrname" name="edit_name">


                        </div>


                    </div>
                    <div class="modal-footer d-flex">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @include('common.footerjs')

    <script>
        // Edit button click
        $('.edit-btn').on('click', function() {
            let id = $(this).data('id');

            let name = $(this).data('name');

            // Fill the modal fields
            $('#edittagmasterId').val(id);
            $('#editStrname').val(name);


            // ✅ Set form action dynamically
            $('#editTagmasterForm').attr('action', "{{ route('TageMaster.update') }}");

            // Show modal
            $('#editTagmasterModal').modal('show');
        });

        // Bulk delete
        /*$('#bulkDeleteBtn').on('click', function() {
            if(confirm('Are you sure you want to delete selected records?')) {
                $('#bulkDeleteForm').submit();
            }
        });*/

        $('#bulkDeleteBtn').on('click', function() {
            var ids = $('input[name="ids[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                alert("Please select at least one record to delete.");
                return;
            }

            if (confirm('Are you sure you want to delete selected records?')) {
                $.ajax({
                    url: "{{ route('admin.category.bulk-delete') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids
                    },
                    success: function(response) {
                        alert('Deleted successfully.');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('An error occurred.');
                    }
                });
            }
        });


        // Select all checkbox
        $('#selectAll').on('click', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
        });

        (function() {
            function toSlug(s) {
                return (s || '')
                    .toString()
                    .normalize('NFKD') // handle accents
                    .replace(/[\u0300-\u036f]/g, '') // strip diacritics
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-') // non-alnum -> hyphen
                    .replace(/^-+|-+$/g, '') // trim dashes
                    .substring(0, 50); // keep within your maxlength
            }

            const nameEl = document.getElementById('strCategoryName');
            const slugEl = document.getElementById('strSlug');
            const editNameEl = document.getElementById('editStrCategoryName');
            const editSlugEl = document.getElementById('editStrSlug');

            let userEditedCreateSlug = false;
            let userEditedEditSlug = false;

            // If user types in slug manually, stop auto-sync for that form
            slugEl?.addEventListener('input', () => userEditedCreateSlug = true);
            editSlugEl?.addEventListener('input', () => userEditedEditSlug = true);

            // Create form: name -> slug (only if user hasn't touched slug)
            nameEl?.addEventListener('input', function() {
                if (!userEditedCreateSlug) slugEl.value = toSlug(this.value);
            });

            // Edit modal: name -> slug (only if user hasn't touched slug)
            editNameEl?.addEventListener('input', function() {
                if (!userEditedEditSlug) editSlugEl.value = toSlug(this.value);
            });

            // If the form loads with empty slug, prime it from name once
            if (nameEl && slugEl && !slugEl.value) slugEl.value = toSlug(nameEl.value);
        })();
    </script>
@endsection
