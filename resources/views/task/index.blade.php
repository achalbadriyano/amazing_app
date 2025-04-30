@extends('layouts.main')

@section('container')
    <div class="row mt-3 ps-4">
        <div class="col-8">
            <div class="mt-3">
                <nav aria-label="breadcrumb mt-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none"
                                href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Task</li>
                    </ol>
                </nav>
            </div>
            <h1 class="text-dark">Task Complete App</h1>

            <!-- FORM INPUT TASK -->
            <form id="taskForm">
                @csrf
                <div class="mb-3 col-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="date" class="form-label">Date Complete</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="time" class="form-label">Time Complete</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <button type="submit" class="btn btn-warning mb-4">Submit</button>
            </form>

            <!-- TABEL TASKS -->
            <div class="col-8">
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
        </div>
        <div class="col-2"></div>
        <div class="col-2"></div>
    </div>
@endsection
