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
                    <li><a href="/vacancies?position=">- All -</a></li>
                    @foreach($positions as $p)
                        <li><a href="/vacancies?position={{ $p['id'] }}">{{ $p['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn btn-sm m-1">Filter Status</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                    <li><a href="/vacancies?status=">- All -</a></li>
                    <li><a href="/vacancies?status=t">Approved</a></li>
                    <li><a href="/vacancies?status=p">Pending</a></li>
                    <li><a href="/vacancies?status=f">Rejected</a></li>
                </ul>
            </div>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead class="bg-base-200">
            <tr>
                <th width="20"></th>
                <th width="100">Applicant ID</th>
                <th width="100">Applicant Name</th>
                <th width="100">Position</th>
                <th width="100">Placement Location</th>
                <th width="100">Selection Passed Date</th>
                <th width="100">Placement Date</th>
                <th width="100">Status</th>
            </tr>

            </thead>
            <tbody>
            @forelse($datas as $no => $r)
                <tr>
                    <th align="center">{{ $datas->firstItem() + $no }}.</th>
                    <td></td>
                    <td>{{ $r->applicant->name }}</td>
                    <td>{{ $r->vacancy->staff_request->position->name }}</td>
                    <td>{{ $placement_locations[$r->location] }}</td>
                    <td>{{ $r->created_at ? date('j F Y', strtotime($r->created_at)) : '-' }}</td>
                    <td>{{ $r->appointment_date ? date('j F Y', strtotime($r->appointment_date)) : '-' }}</td>
                    <td>
                        <x-button-status-appoint href="#appr" onclick="openEditModal({{ $r->id }})">{{ $r->status }}</x-button-status-appoint>
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
    function openEditModal(id) {
        fetch('/appointments_edit/' + id + '')
            .then(response => response.json())
            .then(data => {

                data.data.appointment_date && (document.getElementById('date').value = data.data.appointment_date);
                data.data.location && (document.getElementById('location').value = data.data.location);
                data.data.notes && (document.getElementById('notes').value = data.data.notes);

                let statusRadios = document.getElementsByName('status');
                statusRadios.forEach(radio => {
                    if (radio.value === data.data.status) {
                        radio.checked = true;
                    }
                });

                document.getElementById('form').action = '/appointments_update/' + data.data.id;
                document.getElementById('modal_dialog').showModal();
            });
    }
</script>

<dialog id="modal_dialog" class="modal">
    <div class="modal-box w-11/12 lg:w-5/12 max-w-3xl">
        <x-header :title="$title">
            <li>Approve Data</li>
        </x-header>

        <form method="POST" id="form">
            @csrf

            <div role="alert" class="alert alert-info alert-soft">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>By completing this form, you are finalizing the appointment process for the selected candidate. Ensure the placement location and date are accurate.</span>
            </div>

            <x-forms.fieldset label="Placement Date" name="date" bag="approve">
                <input type="date" id="date" name="appointment_date" class="input input-sm w-full" value="{{ old('appointment_date', date('Y-m-d')) }}"/>
            </x-forms.fieldset>

            <x-forms.fieldset label="Placement Location" name="location" bag="edit">
                <select class="select select-sm w-full" id="location" name="location" >
                    <option disabled selected>- Pick a Location -</option>
                    @foreach($placement_locations as $key => $label)
                        <option value="{{ $key  }}" {{ old('location') == $p['id'] ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </x-forms.fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Status</legend>
                <div class="flex gap-2">
                    <input type="radio" id="status" name="status" value="t" class="radio radio-sm radio-sm radio-accent" /> <span class="text-sm">Completed</span>
                    <input type="radio" id="status" name="status" value="p" class="radio radio-sm radio-sm radio-warning" /> <span class="text-sm">Scheduled</span>
                    <input type="radio" id="status" name="status" value="f" class="radio radio-sm radio-sm radio-error" /> <span class="text-sm">Cancelled</span>
                </div>
            </fieldset>

            <x-forms.fieldset label="Note" name="notes" bag="approve">
                <textarea class="textarea h-24 w-full" id="notes" name="notes">{{ old('notes') }}</textarea>
            </x-forms.fieldset>


            <input type="submit" class="btn btn-sm btn-primary my-2">
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>Close</button>
    </form>
</dialog>

