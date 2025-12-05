@extends('layouts.app')

@section('title', 'Celebrity OR Designer')

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
                                <h4 class="card-title mb-0">Add</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('Celebrity_Designer.store') }}" id="categoryForm"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="Image" class="form-label">Image </label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            maxlength="50">
                                    </div>

                                    <div class="mb-3">
                                        <label for="Type" class="form-label">Type </label>
                                        <select name="Type" id="Type" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="1">Celebrity</option>
                                            <option value="2">Designer</option>
                                        </select>
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
                                            <th>Sr No</th>
                                            <th>Type</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @forelse($CelebrityORDesigner as $Banner)
                                            <tr>
                                                {{-- <td>
                                                    <input type="checkbox" name="ids[]"
                                                        value="{{ $category->iCategoryId }}">
                                                </td> --}}
                                                <td>{{ $i++ }}</td>

                                                <td>
                                                    @if ($Banner->Type == 1)
                                                        Celebrity
                                                    @elseif($Banner->Type == 2)
                                                        Designer
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($Banner->image)
                                                        <img src="{{ asset('uploads/CelebrityORDesigner/' . $Banner->image) }}"
                                                            style="width:70px;height:50px;object-fit:cover;border-radius:4px;">
                                                    @else
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width:70px;height:50px;object-fit:cover;border-radius:4px;">
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                        data-id="{{ $Banner->id }}" data-image="{{ $Banner->image }}"
                                                        data-type="{{ $Banner->Type }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('Celebrity_Designer.delete', $Banner->id) }}"
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

                                {{ $CelebrityORDesigner->links() }}
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
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Celebrity OR Designer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="editCelebrity_DesignerId">


                        <div class="mb-3">
                            <label for="editStrCelebrityDesignerimage" class="form-label">Image <span
                                    class="text-danger">*</span></label>
                            <!-- Change this to a file input -->
                            <input type="file" class="form-control" id="editCelebrityDesignerimage"
                                name="edit_CelebrityDesigner">
                            <input type="hidden" name="hiddenimagePhoto" id="hiddenimagePhoto" value="">

                            <div class="mt-2">
                                <!-- Display current image preview -->
                                <img class="img-fluid" src="" alt="Current Image" height="50" width="50"
                                    id="Edit_CelebrityDesigner_Image">
                            </div>
                        </div>

                        <div class="mb-3">
                            <select class="form-control" id="editType" name="editType" required>
                                <option value="">Please Select</option>
                                <option value="1">Celebrity</option>
                                <option value="2">Designer</option>
                            </select>

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
            let image = $(this).data('image');
            let type = $(this).data('type'); // ← Correct


            // Fill the modal fields
            $('#editCelebrity_DesignerId').val(id);
            $('#editType').val(type);

            // ✅ Build correct image URL
            var imageUrl = image ?
                "{{ asset('uploads/CelebrityORDesigner') }}/" + image :
                "{{ asset('assets/images/noimage.png') }}";

            // ✅ Set preview and hidden image field
            $('#Edit_CelebrityDesigner_Image').attr('src', imageUrl);
            $('#hiddenimagePhoto').val(image);

            // ✅ Set form action dynamically
            $('#editCategoryForm').attr('action', "{{ route('Celebrity_Designer.update') }}");

            // Show modal
            $('#editCategoryModal').modal('show');
        });
    </script>
@endsection
