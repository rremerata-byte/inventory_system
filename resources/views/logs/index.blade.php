@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="logs-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>📋 Activity Logs</h1>
    </div>

    <!-- Logs Table -->
    <div class="card">
        <div class="card-header">
            <h3>Audit Trail ({{ $logs->total() }} total)</h3>
        </div>
        <div class="card-body">
            @if($logs->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->logged_at ? $log->logged_at->format('M d, Y H:i:s') : '-' }}</td>
                            <td class="font-weight-bold">{{ $log->user->name }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->details }}</td>
                            <td>
                                <span class="badge {{ $log->color_class }}">
                                    @if($log->color_class === 'badge-success')
                                        ✓ Success
                                    @elseif($log->color_class === 'badge-danger')
                                        ✗ Deleted
                                    @elseif($log->color_class === 'badge-info')
                                        ⓘ Updated
                                    @else
                                        {{ ucfirst(str_replace('badge-', '', $log->color_class)) }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $logs->links() }}
            </div>
            @else
            <p class="text-center text-muted">No activity logs yet.</p>
            @endif
        </div>
    </div>
</div>

<style>
.logs-container {
    padding: 20px;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 2rem;
    margin: 0;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    color: #2c3e50;
}

.card-body {
    padding: 20px;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.data-table thead {
    background: #f8f9fa;
}

.data-table th {
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #ddd;
}

.data-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.data-table tbody tr:hover {
    background: #f8f9fa;
}

.font-weight-bold {
    font-weight: bold;
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #27ae60;
    color: white;
}

.badge-danger {
    background: #e74c3c;
    color: white;
}

.badge-info {
    background: #3498db;
    color: white;
}

.badge-warning {
    background: #f39c12;
    color: white;
}

.text-muted {
    color: #7f8c8d;
}

.text-center {
    text-align: center;
}

.pagination-wrapper {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .data-table {
        font-size: 12px;
    }

    .data-table th, .data-table td {
        padding: 8px;
    }
}
</style>
@endsection
