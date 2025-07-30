<x-layout>
    <x-header :title="$title"></x-header>
    @if (session('success'))
        <x-alert-top></x-alert-top>
    @endif

    <div class="flex justify-between mb-2">
        <form>
            @if(request('position'))
                <input type="hidden" id="position" name="position" value="{{ request('position') }}">
            @endif
            @if(request('status'))
                <input type="hidden" id="status" name="status" value="{{ request('status') }}">
            @endif

            <div class="join">
                <div>
                    <label class="input input-sm w-80 validator join-item">
                        <x-icon-search></x-icon-search>
                        <input type="text" id="search" name="search" placeholder="Search" value="{{ request('search') }}"/>
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-neutral join-item">GO</button>
            </div>
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn btn-sm m-1">Filter Position</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                    <li><a href="/staff_request?position=">- All -</a></li>
                    @foreach($positions as $p)
                        <li><a href="/staff_request?position={{ $p['id'] }}">{{ $p['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn btn-sm m-1">Filter Status</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                    <li><a href="/staff_request?status=">- All -</a></li>
                    <li><a href="/staff_request?status=t">Approved</a></li>
                    <li><a href="/staff_request?status=p">Pending</a></li>
                    <li><a href="/staff_request?status=f">Rejected</a></li>
                </ul>
            </div>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead class="bg-base-200">
            <tr>
                <th width="20"></th>
                <th width="150">Created At</th>
                <th width="150">Request ID</th>
                <th width="150">Position</th>
                <th width="150">Applicant ID</th>
                <th width="*">Applicant Name</th>
                <th width="100">Phone Number</th>
                <th width="100">Selection Date</th>
                <th width="100">Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($datas as $no => $r)
                <tr>
                    <th align="center">{{ $datas->firstItem() + $no }}.</th>
                    <td>{{ $r->created_at->diffForHumans() }}</td>
                    <td>{{ $r->vacancy->staff_request->number }}</td>
                    <td>{{ $r->vacancy->staff_request->position->name }}</td>
                    <td></td>
                    <td>{{ $r->applicant->name }}</td>
                    <td>{{ $r->applicant->telephone }}</td>
                    <td>{{ $r->app_date ? date('j F Y', strtotime($r->app_date)) : '-' }}</td>
                    <td>
                        <x-button-status
                            href="#appr"
                            onclick="{{ auth()->user()->group_id == 4 ? '' : 'openApproveModal(' . $type . ', ' . $r->id . ')' }}"
                        >
                            {{ $r->app_status }}
                        </x-button-status>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="9">
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
        {{ $datas->links('vendor.pagination.tailwind') }}

    </div>

</x-layout>

<script>
    function openApproveModal(type, id) {
        fetch('/selection_approve/' + type + '/' + id + '')
            .then(response => response.json())
            .then(data => {

                data.approve_by && (document.getElementById('app_by').value = data.approve_by.name);
                data.app_date && (document.getElementById('app_date').value = data.app_date);

                let statusRadios = document.getElementsByName('app_status');
                statusRadios.forEach(radio => {
                    if (radio.value === data.app_status) {
                        radio.checked = true;
                    }
                });
                document.getElementById('app_note').value = data.app_note;

                document.getElementById('app_form').action = '/selection_update_appr/' + type + '/' + data.id;
                document.getElementById('app_modal_dialog').showModal();
            });
    }
</script>

<dialog id="app_modal_dialog" class="modal">
    <div class="modal-box w-11/12 md:w-5/12 max-w-3xl">
        <x-header :title="$title">
            <li>Approve Data</li>
        </x-header>

        <form method="POST" id="app_form">
            @csrf

            @if($type == 7)
                <div role="alert" class="alert alert-warning alert-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>By approving this final selection stage, you acknowledge that the applicant has successfully passed all recruitment steps and you agree to proceed with the employment appointment.</span>
                </div>
            @endif

            <x-forms.fieldset label="By" name="app_by" bag="approve">
                <input type="text" id="app_by" name="app_by" class="input input-sm w-full" value="{{ old('app_by', auth()->user()->name) }}" disabled/>
            </x-forms.fieldset>

            <x-forms.fieldset label="Date" name="app_date" bag="approve">
                <input type="date" id="app_date" name="app_date" class="input input-sm w-full" value="{{ old('app_date', date('Y-m-d')) }}"/>
            </x-forms.fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Page title</legend>
                <div class="flex gap-2">
                    <input type="radio" id="app_status" name="app_status" value="t" class="radio radio-sm radio-sm radio-accent" /> <span class="text-sm">Approve</span>
                    <input type="radio" id="app_status" name="app_status" value="p" class="radio radio-sm radio-sm radio-warning" /> <span class="text-sm">Pending</span>
                    <input type="radio" id="app_status" name="app_status" value="f" class="radio radio-sm radio-sm radio-error" /> <span class="text-sm">Reject</span>
                </div>
            </fieldset>

            <x-forms.fieldset label="Note" name="app_note" bag="approve">
                <textarea class="textarea h-24 w-full" id="app_note" name="app_note">{{ old('note') }}</textarea>
            </x-forms.fieldset>


            <input type="submit" class="btn btn-sm btn-primary my-2">
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>Close</button>
    </form>
</dialog>

@if (session('app_id'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            openEditModal({{ session('app_id') }});
        });
    </script>
@endif
