@extends('layouts.app')

@section('title', 'Browse Courses - Xperium Academy')

@section('content')
<style>
    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1.125rem;
        color: var(--text-secondary);
        margin: 0;
    }

    /* Search & Filter Card */
    .filter-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .filter-header {
        background: var(--secondary-bg);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .filter-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .filter-body {
        padding: 2rem;
    }

    /* Form Styles */
    .form-label {
        color: var(--text-primary);
        font-weight: 500;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        background: var(--secondary-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 0.55rem 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background: var(--secondary-bg);
        border-color: var(--accent);
        color: var(--text-primary);
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .form-control option {
        background: var(--secondary-bg);
        color: var(--text-primary);
    }

    /* Buttons */
    .modern-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    .btn-primary-modern {
        background: var(--accent);
        color: var(--primary-bg);
    }

    .btn-primary-modern:hover {
        background: var(--text-secondary);
        color: var(--primary-bg);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-outline-modern {
        background: transparent;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-outline-modern:hover {
        background: var(--hover);
        border-color: var(--hover);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Course Cards */
    .course-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-4px);
        border-color: var(--hover);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .course-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .course-image-placeholder {
        height: 200px;
        background: var(--hover);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 3rem;
    }

    .course-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .course-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        flex: 1;
    }

    .course-badges {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .modern-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-category {
        background: rgba(160, 160, 160, 0.15);
        color: var(--text-secondary);
        border: 1px solid rgba(160, 160, 160, 0.3);
    }

    .badge-duration {
        background: rgba(59, 130, 246, 0.15);
        color: var(--info);
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .badge-capacity {
        background: rgba(156, 163, 175, 0.15);
        color: var(--text-muted);
        border: 1px solid rgba(156, 163, 175, 0.3);
    }

    .course-details {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .instructor-info h6 {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .instructor-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .price-info {
        text-align: right;
    }

    .price-info h6 {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--success);
        margin: 0;
    }

    .availability {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }

    .availability.available {
        color: var(--success);
    }

    .availability.unavailable {
        color: var(--text-muted);
    }

    .course-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        margin-top: auto;
    }

    /* Results Info */
    .results-info {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    /* Empty State */
    .empty-state {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--hover);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--text-muted);
        font-size: 2rem;
    }

    .empty-state h5 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    .page-link {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.75rem 1rem;
        margin: 0 0.125rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background: var(--hover);
        border-color: var(--hover);
        color: var(--text-primary);
    }

    .page-item.active .page-link {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary-bg);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .filter-body {
            padding: 1.5rem;
        }
        
        .course-details {
            flex-direction: column;
            gap: 1rem;
        }
        
        .price-info {
            text-align: left;
        }
    }
</style>

<div class="page-header">
    <h2 class="page-title">Browse Courses</h2>
    <p class="page-subtitle">Discover amazing courses and start your learning journey</p>
</div>

<!-- Search and Filter Form -->
<div class="filter-card">
    <div class="filter-header">
        <h5 class="filter-title">Search & Filter Courses</h5>
    </div>
    <div class="filter-body">
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
                    <button type="submit" class="modern-btn btn-primary-modern">
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
                        <option value="duration" {{ request('sort_by') == 'duration' ? 'selected' : '' }}>Duration</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Latest</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="sort_order" class="form-label">Order</label>
                    <select class="form-control" id="sort_order" name="sort_order">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('student.courses.index') }}" class="modern-btn btn-outline-modern">
                        Clear Filters
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Course Results -->
<div class="results-info">
    Showing {{ $courses->count() }} of {{ $courses->total() }} courses
    @if(request()->hasAny(['search', 'category_id', 'min_price', 'max_price']))
        (filtered results)
    @endif
</div>

@if($courses->count() > 0)
    <!-- Course Cards -->
    <div class="row">
        @foreach($courses as $course)
            <div class="col-md-6 col-lg-4 col-xl-4 mb-4">
                <div class="course-card">
                    @if($course->image_path)
                        <img src="{{ asset('storage/' . $course->image_path) }}" class="course-image" alt="{{ $course->name }}">
                    @else
                        <div class="course-image-placeholder">
                            <i class="fa fa-book"></i>
                        </div>
                    @endif

                    <div class="course-body">
                        <h6 class="course-title">{{ $course->name }}</h6>
                        <p class="course-description">
                            {{ Str::limit($course->description, 100) }}
                        </p>

                        <div class="course-badges">
                            <span class="modern-badge badge-category">{{ $course->category->name }}</span>
                            <span class="modern-badge badge-duration">{{ $course->formatted_duration }}</span>
                            <span class="modern-badge badge-capacity">{{ $course->max_participants }} students</span>
                        </div>

                        <div class="course-details">
                            <div class="instructor-info">
                                <h6>Instructor</h6>
                                <div class="instructor-name">{{ $course->instructor_name }}</div>
                            </div>
                            <div class="price-info">
                                <h6>Price</h6>
                                <h5 class="price">Rp.{{ number_format($course->price) }}</h5>
                            </div>
                        </div>

                        @if($course->schedules->count() > 0)
                            <div class="availability available">
                                <i class="fa fa-calendar"></i>
                                {{ $course->schedules->count() }} available sessions
                            </div>
                        @else
                            <div class="availability unavailable">
                                <i class="fa fa-calendar-o"></i>
                                No sessions available
                            </div>
                        @endif
                    </div>

                    <div class="course-footer">
                        <a href="{{ route('student.courses.show', $course) }}" class="modern-btn btn-primary-modern">
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
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fa fa-search"></i>
        </div>
        <h5>No Courses Found</h5>
        @if(request()->hasAny(['search', 'category_id', 'min_price', 'max_price']))
            <p>No courses match your search criteria. Try adjusting your filters.</p>
            <a href="{{ route('student.courses.index') }}" class="modern-btn btn-primary-modern" style="max-width: 200px; margin: 0 auto;">
                Clear Filters
            </a>
        @else
            <p>There are no courses available at the moment.</p>
        @endif
    </div>
@endif
@endsection