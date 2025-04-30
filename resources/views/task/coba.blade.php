<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Complete App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .delete-header {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .task-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #tasksTable_wrapper .dataTables_scrollBody {
            max-height: 400px;
            overflow-y: scroll;
        }

        #tasksTable {
            width: 100%;
            table-layout: fixed;
        }
    </style>
</head>

<body>

    <div class="container-sm mt-4">
        <div class="row">
            <div class="col"></div>
            <div class="col-8 bg-primary rounded-2 p-4">
                <h1 class="text-center text-white">Task Complete App</h1>

                <!-- FORM INPUT TASK -->
                <form id="taskForm">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date Complete</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time Complete</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <button type="submit" class="btn btn-warning mb-4">Submit</button>
                </form>

                <!-- TABEL TASKS -->
                <h2>Task Completed Lists</h2>
                <table class="table table-bordered" id="tasksTable">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <div class="delete-header">
                                    <input type="checkbox" id="selectAll">
                                    <button class="btn btn-danger btn-sm" id="deleteSelected" disabled>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </th>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tambahan untuk tombol export -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#tasksTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tasks.data') }}",
                scrollY: "400px",
                scrollCollapse: true,
                paging: false,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `
                            <div class="task-actions">
                                <input type="checkbox" class="task-checkbox" value="${data}">
                                <button class="btn btn-danger btn-sm delete-task" data-id="${data}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    }
                ]
            });

            $('#taskForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('tasks.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        alert(response.message);
                        $('#taskForm')[0].reset();
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert("Terjadi kesalahan, silakan coba lagi.");
                    }
                });
            });

            $(document).on('click', '.delete-task', function() {
                let taskId = $(this).data('id');
                if (confirm("Apakah Anda yakin ingin menghapus task ini?")) {
                    $.ajax({
                        url: "/tasks/" + taskId,
                        type: "DELETE",
                        success: function(response) {
                            alert(response.message);
                            table.ajax.reload();
                        },
                        error: function() {
                            alert("Gagal menghapus task.");
                        }
                    });
                }
            });

            $('#selectAll').on('click', function() {
                $('.task-checkbox').prop('checked', this.checked);
                toggleDeleteButton();
            });

            $(document).on('change', '.task-checkbox', function() {
                let allChecked = $('.task-checkbox').length === $('.task-checkbox:checked').length;
                $('#selectAll').prop('checked', allChecked);
                toggleDeleteButton();
            });

            $('#deleteSelected').on('click', function() {
                let selectedTasks = $('.task-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedTasks.length === 0) {
                    alert("Pilih setidaknya satu task untuk dihapus!");
                    return;
                }

                if (confirm("Apakah Anda yakin ingin menghapus task yang dipilih?")) {
                    $.ajax({
                        url: "/tasks/delete-multiple",
                        type: "POST",
                        data: {
                            ids: selectedTasks
                        },
                        success: function(response) {
                            alert(response.message);
                            table.ajax.reload();
                            $('#selectAll').prop('checked', false);
                            toggleDeleteButton();
                        },
                        error: function() {
                            alert("Gagal menghapus task.");
                        }
                    });
                }
            });

            function toggleDeleteButton() {
                let selectedCount = $('.task-checkbox:checked').length;
                $('#deleteSelected').prop('disabled', selectedCount === 0);
            }
        });
    </script>

</body>

</html>
