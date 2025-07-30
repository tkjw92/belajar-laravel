<div class="modal fade" id="books_edit_modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("books.edit") }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id">
                @csrf
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="mb-3">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old("title") }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="5">{{ old("description") }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Counts</label>
                        <input type="number" class="form-control" name="counts" value="{{ old("counts") }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cover</label>
                        <input type="file" class="form-control" name="cover">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-danger delete-button">Delete</button>
                    </div>

                    <div>
                        <button type="button" class="btn btn-muted" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
