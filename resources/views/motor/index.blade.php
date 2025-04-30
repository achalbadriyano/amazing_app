@extends('layouts.main')

@section('container')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-md-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Motor</li>
                    </ol>
                </nav>

                <h1>Motor History App</h1>
                <h4 class="mt-3">Input History</h4>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- FORM INPUT -->
                <form action="{{ url('/motor/store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title"
                            value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name='date' class="form-control" id="date"
                            value="{{ old('date') }}">
                        @error('date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" name="time" class="form-control" id="time"
                            value="{{ old('time') }}">
                        @error('time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-warning mb-4">Submit</button>
                </form>

                <!-- TABLE -->
                <h3>History List</h3>
                <div class="table-responsive">
                    <table id="historyTable" class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $key => $history)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $history->title }}</td>
                                    <td>{{ $history->description }}</td>
                                    <td>{{ $history->date }}</td>
                                    <td>{{ $history->time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
