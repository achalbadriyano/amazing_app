@php
    $title = match ($active) {
        'home' => 'Home',
        'task' => 'Task',
        'motor' => 'Motor',
        default => '',
    };
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $title }} | Amazing App</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    {{-- Datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
</head>

<body>

    @include('partials.navbar')
    @yield('container')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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
