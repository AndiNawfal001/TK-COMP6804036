<x-layout>
    <x-header title="Dashboard" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">

        <!-- Card: Total Users -->
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Total Users</div>
                <div class="stat-value text-primary">{{ $totalUsers }}</div>
                <div class="stat-desc">Including Admins and Applicants</div>
            </div>
        </div>

        <!-- Card: Total Vacancies -->
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Job Vacancies</div>
                <div class="stat-value text-secondary">{{ $totalVacancies }}</div>
                <div class="stat-desc">Currently Available</div>
            </div>
        </div>

        <!-- Card: Applications This Month -->
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Applications (This Month)</div>
                <div class="stat-value text-success">{{ $applicationsThisMonth }}</div>
                <div class="stat-desc">Submitted by Applicants</div>
            </div>
        </div>
    </div>

    <!-- Selection Progress Overview -->
    <div class="my-6">
        <h2 class="text-lg font-semibold mb-2">Selection Process Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($selectionTypes as $type)
                <div class="card bg-base-100 shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title text-sm">{{ $type->name }}</h3>
                        <p class="text-xl font-bold">{{ $type->total }}</p>
                        <p class="text-xs text-gray-500">Applicants in this phase</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <canvas id="selectionPieChart" class="max-w-md mx-auto my-6"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('selectionPieChart').getContext('2d');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Applicants per Selection Type',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                        '#6366F1', '#8B5CF6', '#EC4899', '#F472B6'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <!-- Latest Applications Table -->
    <div class="overflow-x-auto bg-base-100 shadow rounded-box mt-6">
        <table class="table table-zebra table-sm w-full">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Vacancy</th>
                <th>Status</th>
                <th>Applied At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recentApplications as $i => $app)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $app->applicant->name }}</td>
                    <td>{{ $app->vacancy->title }}</td>
                    <td>
                            <span class="badge badge-sm badge-outline">
                                {{ $app->status ?? 'Waiting' }}
                            </span>
                    </td>
                    <td>{{ $app->created_at->format('j F Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
