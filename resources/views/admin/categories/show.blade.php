@extends('layouts.app')

@section('title', $category->name . ' - Category Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Category Details</h2>
                <div>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Category
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">
                        <i class="fa fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ $category->name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Status:</strong>
                                    @if($category->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Total Courses:</strong>
                                    <span class="badge badge-info">{{ $category->courses->count() }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Description</h6>
                                @if($category->description)
                                    <p>{{ $category->description }}</p>
                                @else
                                    <p class="text-muted">No description provided.</p>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Created</h6>
                                    <p><i class="fa fa-calendar"></i> {{ $category->created_at ? $category->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Last Updated</h6>
                                    <p><i class="fa fa-clock-o"></i> {{ $category->updated_at ? $category->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Associated Courses -->
                    @if($category->courses->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Courses in this Category ({{ $category->courses->count() }})</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Course Name</th>
                                                <th>Instructor</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->courses as $course)
                                                <tr>
                                                    <td>{{ $course->name }}</td>
                                                    <td>{{ $course->instructor_name }}</td>
                                                    <td>${{ number_format($course->price, 2) }}</td>
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
                                                        <a href="{{ route('admin.courses.show', $course) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card mt-4">
                            <div class="card-body text-center">
                                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                                <h5>No Courses</h5>
                                <p class="text-muted">This category doesn't have any courses yet.</p>
                                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add Course
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-block">
                                    <i class="fa fa-edit"></i> Edit Category
                                </a>
                                <a href="{{ route('admin.courses.create') }}?category={{ $category->id }}" class="btn btn-info btn-block">
                                    <i class="fa fa-plus"></i> Add Course
                                </a>
                                @if($category->courses->count() == 0)
                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fa fa-trash"></i> Delete Category
                                        </button>
                                    </form>
                                @else
                                    <button type="button" 
                                            class="btn btn-danger btn-block" 
                                            disabled 
                                            title="Cannot delete category with courses">
                                        <i class="fa fa-trash"></i> Delete Category
                                    </button>
                                    <small class="text-muted">Remove all courses before deleting</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Category Statistics -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h4 class="text-primary">{{ $category->courses->count() }}</h4>
                                    <small class="text-muted">Total Courses</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success">{{ $category->courses->where('status', 'active')->count() }}</h4>
                                    <small class="text-muted">Active Courses</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection