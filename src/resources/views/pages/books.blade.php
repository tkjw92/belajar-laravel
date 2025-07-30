@extends("layouts.master")

@section("content")
    @if (Auth::user()->role == "admin")
        <div class="row mb-5">
            <div class="col text-end">
                <a href="?edit=1" class="btn btn-warning">
                    <i class="ti ti-edit"></i>
                    Edit Book
                </a>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#books_add_modal">
                    <i class="ti ti-plus"></i>
                    Add Book
                </button>
            </div>
        </div>
    @endif

    <div class="row mb-5">
        <div class="col">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search"
                value="{{ $request->search }}">
        </div>
    </div>

    @if (session("error_body"))
        <div class="row">
            <div class="col">
                <div class="alert alert-danger">
                    {{ session("error_body") }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @foreach ($books as $book)
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset("storage/" . $book->cover) }}" class="card-img-top">
                    <div class="card-body">
                        @if ($book->counts > 0)
                            <span class="badge bg-success mb-2">Available ({{ $book->available }} Books)</span>
                        @else
                            <span class="badge bg-danger mb-2">Unavailable</span>
                        @endif
                        <h5 class="card-title text-capitalize" role="button" onclick="historyBook({{ $book->id }})">
                            {{ $book->title }}
                        </h5>

                        <p class="card-text">{{ $book->description }}</p>
                        <button class="btn btn-primary" onclick="borrowBook({{ $book->id }})">
                            Borrow this book <i class="ti ti-arrow-right"></i>
                        </button>

                        @if ($request->edit)
                            <button onclick="editBook({{ $book->id }})" class="btn btn-warning mt-3">
                                <i class="ti ti-edit"></i>
                                Edit
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include("modal.books.add")
    @include("modal.books.edit")
    @include("modal.books.delete")

    @include("modal.borrow.confirm")
    @include("modal.borrow.history")
@endsection

@section("script")
    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }
    </script>

    <!-- Main script -->
    <script>
        const searchBox = document.getElementById('search');
        searchBox.addEventListener('keyup', delay(function() {
            if (searchBox.value) {
                location.href = '?search=' + searchBox.value;
            } else {
                location.href = '.';
            }
        }, 500));

        function editBook(id) {
            const book = fetch('/books/get/' + id)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    const editModal = document.getElementById('books_edit_modal');
                    editModal.querySelector('[name=title]').value = data.title;
                    editModal.querySelector('[name=description]').value = data.description;
                    editModal.querySelector('[name=counts]').value = data.counts;
                    editModal.querySelector('[name=id]').value = data.id;

                    editModal.querySelector('.delete-button').setAttribute('onclick', `deleteBook(${data.id})`);
                });

            $('#books_edit_modal').modal('show');
        }

        function deleteBook(id) {
            $('#books_edit_modal').modal('hide');
            $('#books_delete_modal').modal('show');

            const deleteModal = document.getElementById('books_delete_modal');
            deleteModal.querySelector('[name=id]').value = id;
        }

        function borrowBook(id) {
            $('#borrow_confirm_modal').modal('show');

            const borrowModal = document.getElementById('borrow_confirm_modal');
            borrowModal.querySelector('.borrow-button').href = '/borrow/' + id;
        }

        function historyBook(id) {
            $('#borrow_history_modal').modal('show');
            const data = fetch('/borrow/history/book/' + id)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    const historyModal = document.getElementById('borrow_history_modal');
                    const tbody = historyModal.querySelector('table tbody');

                    tbody.innerHTML = "";

                    for (let i = 0; i < data.length; i++) {
                        tbody.innerHTML +=
                            `<tr>
                                <td>${i+1}</td>
                                <td class="text-capitalize">${data[i].name}</td>
                                <td>${data[i].created_at}</td>
                                <td>${data[i].return_at ?? '-'}</td>
                            </tr>`;
                    }
                });
        }
    </script>

    <!-- If validator fails -->
    <script>
        const error_status = "{{ session("error_add") ? "error_add" : (session("error_edit") ? "error_edit" : "") }}";

        $(document).ready(function() {
            switch (error_status) {
                case 'error_add':
                    $('#books_add_modal').modal('show');
                    break;
                case 'error_edit':
                    $('#books_edit_modal').modal('show');
                    break;
            }
        });
    </script>
@endsection
