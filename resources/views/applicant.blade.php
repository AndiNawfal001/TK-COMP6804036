<x-layout>

    <x-header :title="$title"></x-header>


    <div class="overflow-x-auto">
        <table class="table table-md">
            <thead class="bg-base-200">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Job</th>
                    <th>company</th>
                    <th>location</th>
                    <th>Last Login</th>
                    <th>Favorite Color</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0 ;?>
                @forelse($datas as $r)
                    <?php $no++?>
                    <tr>
                        <th>{{ $no }}</th>
                        <td>{{ $r['name'] }}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7">
                            <div role="alert" class="alert alert-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>No Data Available!</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layout>
