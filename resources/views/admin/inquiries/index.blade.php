@extends('layouts.app')

@section('title', 'Inquiry List')

@section('content')

    {{-- Alert Messages --}}
    @include('common.alert')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                {{--  <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Industry</h4>
                        </div>
                    </div>
                </div>  --}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="">

                                    <h5 class="card-title mb-0">Inquiry List</h5>
                                </div>
                                <div class="">

                                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete All
                                    </button>

                                    <a href="{{ route('Inquiry.export') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-download"></i> Export CSV
                                    </a>
                                </div>

                            </div>

                            <div class="card-body">
                                <form method="POST" id="bulkDeleteForm" action="{{ route('Inquiry.bulk-delete') }}">
                                    @csrf
                                    <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th scope="col">No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Business Type</th>
                                                {{-- <th scope="col">Address</th> --}}
                                                <th scope="col">State</th>
                                                <th scope="col">City</th>
                                                <th scope="col">Country</th>
                                                {{-- <th scope="col">Pincode</th> --}}
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($inquiries as $inquiry)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="ids[]"
                                                            value="{{ $inquiry->inquiry_id }}">
                                                    </td>
                                                    <td>{{ $i + $inquiries->perPage() * ($inquiries->currentPage() - 1) }}
                                                    <td class="py-2 px-3">{{ $inquiry->name }}</td>
                                                    <td class="py-2 px-3">{{ $inquiry->mobileNumber }}</td>
                                                    <td class="py-2 px-3">{{ $inquiry->email }}</td>
                                                    <td class="py-2 px-3">{{ $inquiry->business_type }}</td>
                                                    {{-- <td class="py-2 px-3">{{ $inquiry->address ?? '' }}</td> --}}
                                                    <td class="py-2 px-3">{{ $inquiry->state ?? '' }}</td>
                                                    <td class="py-2 px-3">{{ $inquiry->city ?? '' }}</td>
                                                    <td class="py-2 px-3">{{ $inquiry->country ?? '' }}</td>
                                                    {{-- <td class="py-2 px-3">{{ $inquiry->pincode ?? '' }}</td> --}}

                                                    <td>
                                                        <div class="gap-2">

                                                            <a class=""
                                                                href="{{ route('Inquiry.view', [$inquiry->inquiry_id]) }}"
                                                                title="View">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="" href="#" data-bs-toggle="modal"
                                                                title="Delete" data-bs-target="#deleteRecordModal"
                                                                onclick="deleteData(<?= $inquiry->inquiry_id ?>);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $inquiries->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <!--Delete Modal Start -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                        </lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this
                                Record
                                ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <a class="btn btn-primary mx-2" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <button type="button" class="btn w-sm btn-primary mx-2" data-bs-dismiss="modal">Close</button>
                        <form id="user-delete-form" method="POST" action="{{ route('Inquiry.delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="inquiry_id" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete modal End -->



@endsection

@section('scripts')
    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
    <script>
        $('#bulkDeleteBtn').on('click', function() {

            let ids = $('input[name="ids[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                alert("Please select at least one record to delete.");
                return;
            }

            if (!confirm('Are you sure you want to delete selected records?')) {
                return;
            }

            $.ajax({
                url: "{{ route('Inquiry.bulk-delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: ids
                },
                success: function(response) {
                    alert(response.message ?? 'Deleted successfully.');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Something went wrong.');
                }
            });
        });

        // Select all checkbox
        $('#selectAll').on('click', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
        });
    </script>

@endsection
