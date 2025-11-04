@extends('layouts.app')

@section('title', 'Bottom Video')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">


                    <!-- Right side - Listing -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mb-0">Bottom Video Listing</h4>

                            </div>
                            <div class="card-body">
                                <!-- <form method="POST" id="bulkDeleteForm" action="{{ route('admin.category.bulk-delete') }}">
                                                                                                                                                                                                                                                                                                                                                @csrf -->
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Video</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($BottomVideo as $TVideo)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="ids[]" value="{{ $TVideo->id }}">
                                                </td>
                                                <td>{{ $TVideo->video }}</td>


                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                        data-id="{{ $TVideo->id }}" data-video="{{ $TVideo->video }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('BottomVideo.delete', $TVideo->id) }}"
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

                                {{ $BottomVideo->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- page-content -->
    </div> <!-- main-content -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editCategoryForm" enctype="multipart/form-data" action="">
                @csrf
                @method('PUT')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Bottom Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="editvideoid">

                        <div class="mb-3">
                            <label for="editvideo" class="form-label">Video <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editvideo" name="video" required>
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
            let name = $(this).data('video');


            // Fill the modal fields
            $('#editvideoid').val(id);
            $('#editvideo').val(name);

            // ✅ Set form action dynamically
            $('#editCategoryForm').attr('action', "{{ route('BottomVideo.update', ':id') }}".replace(':id', id));


            // Show modal
            $('#editCategoryModal').modal('show');
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
