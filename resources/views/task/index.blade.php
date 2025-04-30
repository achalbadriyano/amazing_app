@extends('layouts.main')

@section('container')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-md-8"> {{-- Kiri tapi tetap responsif --}}
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Task</li>
                    </ol>
                </nav>

                <h1 class="text-dark">Task Complete App</h1>

                <!-- FORM INPUT TASK -->
                <form id="taskForm" class="mt-3">
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
                <h2 class="mt-4">Task Completed List</h2>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tasksTable">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" id="selectAll" class="me-2">
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
            </div>
        </div>
    </div>
@endsection
