<div class="modal fade" id="books_delete_modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("books.delete") }}" method="post">
                <input type="hidden" name="id">
                @csrf
                <div class="modal-body">
                    <h5 class="text-danger">
                        Are you sure, want delete this book ?
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-muted" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
