@extends('layouts.app')

@section('title', 'Browse Courses - Course Booking System')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2>Browse Courses</h2>
            <p class="text-muted">Discover amazing courses and start your learning journey</p>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Search & Filter Courses</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('student.courses.index') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Search by course name, instructor...">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="min_price" class="form-label">Min Price</label>
                                <input type="number" class="form-control" id="min_price" name="min_price"
                                    value="{{ request('min_price') }}" placeholder="0" min="0" step="0.01">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="max_price" class="form-label">Max Price</label>
                                <input type="number" class="form-control" id="max_price" name="max_price"
                                    value="{{ request('max_price') }}" placeholder="1000" min="0" step="0.01">
                            </div>
                            <div class="col-md-1 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="sort_by" class="form-label">Sort By</label>
                                <select class="form-control" id="sort_by" name="sort_by">
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                    <option value="duration" {{ request('sort_by') == 'duration' ? 'selected' : '' }}>Duration
                                    </option>
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                                        Latest</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="sort_order" class="form-label">Order</label>
                                <select class="form-control" id="sort_order" name="sort_order">
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                                    </option>
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <a href="{{ route('student.courses.index') }}" class="btn btn-outline-secondary btn-block">
                                    Clear Filters
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Results -->
    <div class="row mb-3">
        <div class="col-12">
            <p class="text-muted">
                Showing {{ $courses->count() }} of {{ $courses->total() }} courses
                @if(request()->hasAny(['search', 'category_id', 'min_price', 'max_price']))
                    (filtered results)
                @endif
            </p>
        </div>
    </div>

    @if($courses->count() > 0)
        <!-- Course Cards -->
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        @if($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}" class="card-img-top" alt="{{ $course->name }}"
                                style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fa fa-book fa-3x text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h6 class="card-title">{{ $course->name }}</h6>
                            <p class="card-text text-muted small">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <div class="mb-2">
                                <span class="badge badge-secondary">{{ $course->category->name }}</span>
                                <span class="badge badge-info">{{ $course->formatted_duration }}</span>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <small class="text-muted">Instructor:</small><br>
                                    <strong>{{ $course->instructor_name }}</strong>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="text-muted">Price:</small><br>
                                    <h5 class="text-primary mb-0">${{ number_format($course->price, 2) }}</h5>
                                </div>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Max Participants:</small>
                                <span class="badge badge-light">{{ $course->max_participants }} students</span>
                            </div>

                            @if($course->schedules->count() > 0)
                                <div class="mb-2">
                                    <small class="text-success">
                                        <i class="fa fa-calendar"></i>
                                        {{ $course->schedules->count() }} available sessions
                                    </small>
                                </div>
                            @else
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fa fa-calendar-o"></i>
                                        No sessions available
                                    </small>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary btn-block">
                                <i class="fa fa-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $courses->links() }}
            </div>
        </div>
    @else
        <!-- No Courses Found -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fa fa-search fa-3x text-muted mb-3"></i>
                        <h5>No Courses Found</h5>
                        @if(request()->hasAny(['search', 'category_id', 'min_price', 'max_price']))
                            <p class="text-muted">
                                No courses match your search criteria. Try adjusting your filters.
                            </p>
                            <a href="{{ route('student.courses.index') }}" class="btn btn-primary">
                                Clear Filters
                            </a>
                        @else
                            <p class="text-muted">
                                There are no courses available at the moment.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection