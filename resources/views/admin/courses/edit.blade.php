@extends('layouts.admin-layout')

@section('title', 'Edit Course - Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Edit Course: {{ $course->name }}</h2>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Courses
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.courses.update', $course) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Course Name -->
                                    <div class="form-group">
                                        <label for="name">Course Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $course->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">Description *</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" rows="4"
                                            required>{{ old('description', $course->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Instructor Name -->
                                    <div class="form-group">
                                        <label for="instructor_name">Instructor Name *</label>
                                        <input type="text"
                                            class="form-control @error('instructor_name') is-invalid @enderror"
                                            id="instructor_name" name="instructor_name"
                                            value="{{ old('instructor_name', $course->instructor_name) }}" required>
                                        @error('instructor_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Current Image -->
                                    @if($course->image_path)
                                        <div class="form-group">
                                            <label>Current Image</label>
                                            <div>
                                                <img src="{{ asset('storage/' . $course->image_path) }}"
                                                    alt="{{ $course->name }}" class="img-thumbnail mb-2"
                                                    style="max-width: 200px; max-height: 150px;">
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Course Image -->
                                    <div class="form-group">
                                        <label for="image">{{ $course->image_path ? 'Change' : 'Add' }} Course Image</label>
                                        <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Max 2MB, JPEG/PNG only</small>
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group">
                                        <label for="category_id">Category *</label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="status">Status *</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="active" {{ old('status', $course->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $course->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Price -->
                                    <div class="form-group">
                                        <label for="price">Price ($) *</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price', $course->price) }}" step="0.01"
                                            min="0" required>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Duration -->
                                    <div class="form-group">
                                        <label for="duration">Duration (minutes) *</label>
                                        <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                            id="duration" name="duration" value="{{ old('duration', $course->duration) }}"
                                            min="1" required>
                                        @error('duration')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Max Participants -->
                                    <div class="form-group">
                                        <label for="max_participants">Max Participants *</label>
                                        <input type="number"
                                            class="form-control @error('max_participants') is-invalid @enderror"
                                            id="max_participants" name="max_participants"
                                            value="{{ old('max_participants', $course->max_participants) }}" min="1"
                                            required>
                                        @error('max_participants')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Course
                                </button>
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary ml-2">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection