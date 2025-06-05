@extends('layouts.master')
@section('content')
    <h1 class="py-3">Post App</h1>
    <hr class="py-1">

    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <script>
            // Auto-hide after 3 seconds
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500); // Remove after fade effect
                }   
            }, 3000);
        </script>
    @endif

    {{-- add & search --}}
    <div class="d-flex justify-content-between align-items-center ">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-sm btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-user-plus"></i> Add
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <form action="{{ route('posts.store') }}" method="POST">

                            @csrf

                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter product name" required>
                            </div>

                            <!-- Description Field -->
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea name="desc" class="form-control" id="desc" rows="3" placeholder="Enter product description" required></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
    
                </div>
            </div>
        </div>

        
        <form action="">
            <input type="text" name="search">
            <button type="submit">search</button>
        </form>
    </div>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
       <tbody>
            @foreach ($posts as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->description }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $p->id }}">
                            <i class="fa-solid fa-pen-to-square"></i> Update
                        </button>

                        <!-- Delete Button -->
                        <a href="{{ route('posts.delete', $p->id) }}" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure?')">
                            <i class="fa-solid fa-trash"></i> Delete
                        </a>

                        <!-- Modal (Place outside the button) -->
                        <div class="modal fade" id="exampleModal{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $p->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel{{ $p->id }}">Edit Product</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <form action="{{ route('posts.update', $p->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH') <!-- Important -->
                                        

                                            <!-- Name Field -->
                                            <div class="mb-3">
                                                <label for="name{{ $p->id }}" class="form-label">Product Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $p->name }}"
                                                    placeholder="Enter product name" required>
                                            </div>

                                            <!-- Description Field -->
                                            <div class="mb-3">
                                                <label for="desc{{ $p->id }}" class="form-label">Description</label>
                                                <textarea name="desc" class="form-control" id="desc{{ $p->id }}" rows="3"
                                                        placeholder="Enter product description" required>{{ $p->description }}</textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <div class="d-flex justify-content-end align-items-center">
        <p>
            {{ $posts->links('pagination::bootstrap-4') }}
        </p>
    </div>
@endsection


