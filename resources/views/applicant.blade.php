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
                            <div role="alert" class="alert alert-info alert-soft">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>No Data available</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layout>
