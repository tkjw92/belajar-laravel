@extends("layouts.master")

@section("content")
    @if (session("error_body"))
        <div class="mb-3">
            <div class="alert alert-danger">
                <ul>
                    <li>{{ session("error_body") }}</li>
                </ul>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Accounts</h5>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accounts_add_modal">
                        <i class="ti ti-plus"></i>
                        Add
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $count => $user)
                                    <tr>
                                        <td>{{ $count + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="btn btn-sm btn-{{ $user->role == "admin" ? "success" : "info" }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="editAccount({{ $user->id }})">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteAccount({{ $user->id }})">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("modal.accounts.add")
    @include("modal.accounts.edit")
    @include("modal.accounts.delete")
@endsection

@section("script")
    <!-- If validator fails -->
    <script>
        const error_status = "{{ session("error_add") ? "error_add" : (session("error_edit") ? "error_edit" : "") }}";

        $(document).ready(function() {
            switch (error_status) {
                case 'error_add':
                    $('#accounts_add_modal').modal('show');
                    break;
                case 'error_edit':
                    $('#accounts_edit_modal').modal('show');
                    break;
            }
        });
    </script>

    <script>
        function deleteAccount(id) {
            $('#accounts_delete_modal').modal('show');

            const deleteModal = document.getElementById('accounts_delete_modal');
            deleteModal.querySelector('[name=id]').value = id;
        }

        function editAccount(id) {
            const data = fetch('/accounts/get/' + id)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    const editModal = document.getElementById('accounts_edit_modal');
                    editModal.querySelector('[name=id]').value = data.id;
                    editModal.querySelector('[name=name]').value = data.name;
                    editModal.querySelector('[name=email]').value = data.email;
                    editModal.querySelector('[name=role]').value = data.role;
                });

            $('#accounts_edit_modal').modal('show');
        }
    </script>
@endsection
