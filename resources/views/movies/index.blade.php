@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-0">BeeFlix</h1>

    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center ">
                <img src="{{ asset('image/beeflix.png') }}" alt="Beeflix Logo" class="img-fluid" style="max-width: 250px;">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('movies.create') }}" class="btn btn-dark" style="width: 220px">Add New Movie</a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('movies.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search">
            <button class="btn btn-dark" type="submit">Search</button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach ($movies as $movie)
            <div class="col">
                <div class="card h-100 shadow-sm rounded">
                    <img src="{{ asset('storage/'.$movie->photo) }}" alt="{{ $movie->title }}" class="card-img-top" style="width: 100%; height: 400px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p>{{ $movie->genre->name }}</p>
                        <p class="card-text">{{ $movie->description }}</p>
                        <p>{{ \Carbon\Carbon::parse($movie->publish_date)->format('d-m-Y') }}</p>

                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" style="display: inline;" id="delete-form-{{ $movie->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" style="width: 100%" onclick="confirmDelete({{ $movie->id }})">Delete</button>
                        </form>
                    </div>
                </div>
            </div>  
        @endforeach
    </div>

    <div class="mt-4">
        {{ $movies->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection

@section('scripts')
<script>
    function confirmDelete(movieId) {
        if (confirm('Are you sure you want to delete this movie?')) {
            document.getElementById('delete-form-' + movieId).submit();
        }
    }
</script>
@endsection
