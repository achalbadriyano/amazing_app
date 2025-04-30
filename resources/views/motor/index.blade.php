@extends('layouts.main')
@section('container')
    <div class="row mt-3 ps-4">
        <div class="col-8">

            <div class="mt-3">
                <nav aria-label="breadcrumb mt-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none"
                                href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Motor</li>
                    </ol>
                </nav>
            </div>
            <h1 class="">Motor History App</h1>

            <h4 class="mt-3">Input History</h4>

            @if (session('success'))
                <div class="alert alert-success col-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ url('/motor/store') }}" method="POST">
                @csrf
                <div class="mb-3 col-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="10" rows="4"
                        value="{{ old('description') }}"></textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-6">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name='date' class="form-control" id="date" value="{{ old('date') }}">
                    @error('date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-6">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" name="time" class="form-control" id="time" value="{{ old('time') }}">
                    @error('time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning mb-4">Submit</button>
            </form>


            <h3 class="">History List</h3>
            <div class="col-8">
                <table id="historyTable" class="table table-dark table-stripped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
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
        <div class="col-2"></div>
        <div class="col-2"></div>
    </div>
@endsection
