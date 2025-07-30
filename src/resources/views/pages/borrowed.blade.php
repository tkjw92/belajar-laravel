@extends("layouts.master")

@section("content")
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
                        <h5 class="card-title text-capitalize" role="button">
                            {{ $book->title }}
                        </h5>

                        <p class="card-text">{{ $book->description }}</p>
                        <button class="btn btn-primary" onclick="returnBook({{ $book->id }})">
                            Return this book <i class="ti ti-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include("modal.borrow.return")
@endsection

@section("script")
    <!-- Main script -->
    <script>
        function returnBook(id) {
            $('#borrow_return_modal').modal('show');

            const returnModal = document.getElementById('borrow_return_modal');
            returnModal.querySelector('.return-button').href = '/books/return/' + id;
        }
    </script>
@endsection
