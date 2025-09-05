@extends('layouts.app')

@section('title', 'Manage Users - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Manage Users</h2>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New User
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       placeholder="Search users..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="role">
                                    <option value="">All Roles</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                        <div class="col-md-2">
                            @if(request('search') || request('role') || request('status'))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fa fa-times"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if($user->avatar_path)
                                                    <img src="{{ asset('storage/' . $user->avatar_path) }}" 
                                                         alt="{{ $user->name }}" 
                                                         class="rounded-circle" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fa fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->id === auth()->id())
                                                    <span class="badge badge-info badge-sm">You</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="badge badge-danger">Admin</span>
                                                @else
                                                    <span class="badge badge-primary">Student</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->status === 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.users.show', $user) }}" 
                                                       class="btn btn-info" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                                       class="btn btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @if($user->id !== auth()->id())
                                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button type="button" class="btn btn-danger" disabled title="Cannot delete own account">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fa fa-users fa-3x text-muted mb-3"></i>
                            <h4>No users found</h4>
                            <p class="text-muted">No users match your search criteria.</p>
                            @if(request('search') || request('role') || request('status'))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                    <i class="fa fa-times"></i> Clear Filters
                                </a>
                            @else
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Create User
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection