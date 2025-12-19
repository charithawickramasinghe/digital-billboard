<x-layout title="Companies">
    <div class="content">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Companies Management</h3>
                <a href="{{ route('companies.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Company
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($companies->isEmpty())
                <div class="alert alert-info">
                    No companies found. <a href="{{ route('companies.create') }}">Create one</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Postal Code</th>
                                <th>Screens</th>
                                <th>Start Date</th>
                                <th>Renewal Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td><strong>{{ $company->name }}</strong></td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->phone_number }}</td>
                                    <td>{{ $company->address }}</td>
                                    <td>{{ $company->postal_code }}</td>
                                    <td><span class="badge bg-info">{{ $company->screen_count }}</span></td>
                                    <td>{{ $company->start_date->format('M d, Y') }}</td>
                                    <td>{{ $company->renewal_date->format('M d, Y') }}</td>
                                    <td>
                                        @if ($company->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('companies.edit', $company) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layout>
