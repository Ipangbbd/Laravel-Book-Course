@extends('layouts.admin-layout')

@section('title', 'Manage Courses - Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Manage Courses</h2>
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Course
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @if($courses->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Course Name</th>
                                            <th>Category</th>
                                            <th>Instructor</th>
                                            <th>Price</th>
                                            <th>Duration</th>
                                            <th>Max Participants</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courses as $course)
                                            <tr>
                                                <td>
                                                    @if($course->image_path)
                                                        <img src="{{ asset('storage/' . $course->image_path) }}"
                                                            alt="{{ $course->name }}" class="img-thumbnail"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px;">
                                                            <i class="fa fa-book text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $course->name }}</strong><br>
                                                    <small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                                </td>
                                                <td>{{ $course->category->name ?? 'N/A' }}</td>
                                                <td>{{ $course->instructor_name }}</td>
                                                <td>Rp.{{ number_format($course->price, 2) }}</td>
                                                <td>{{ $course->formatted_duration }}</td>
                                                <td>{{ $course->max_participants }}</td>
                                                <td>
                                                    @if($course->status === 'active')
                                                        <span class="badge badge-success">Active</span>
                                                    @elseif($course->status === 'inactive')
                                                        <span class="badge badge-secondary">Inactive</span>
                                                    @else
                                                        <span class="badge badge-warning">Draft</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-info"
                                                            title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                                            style="display: inline;"
                                                            onsubmit="return confirm('Are you sure you want to delete this course?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $courses->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                                <h4>No courses found</h4>
                                <p class="text-muted">Start by creating your first course.</p>
                                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Create Course
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection