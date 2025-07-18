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
        <a href="#add" class="btn btn-sm btn-primary" onclick="openAddModal()">
            Add Data
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead class="bg-base-200">
                <tr>
                    <th width="20"></th>
                    <th width="100">Number</th>
                    <th width="*">Title</th>
                    <th width="150">Input Date</th>
                    <th width="150">Position</th>
                    <th width="20">Qty</th>
                    <th width="150">Request Submitter</th>
                    <th width="50">Status</th>
                    <th width="80">Control</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datas as $no => $r)
                    <tr>
                        <th align="center">{{ $datas->firstItem() + $no }}.</th>
                        <td>{{ $r->number }}</td>
                        <td>{{ $r->title }}</td>
                        <td>{{ $r->date ? date('j F Y', strtotime($r->date)) : '-' }}</td>
                        <td>{{ $r->position?->name }}</td>
                        <td align="center">{{ $r->qty }}</td>
                        <td>{{ Str::limit($r->user_request?->name, 20) }}</td>
                        <td>
                            <x-button-status href="#appr" onclick="openApproveModal({{ $r->id }})">{{ $r->app_status }}</x-button-status>
                        </td>
                        <td align="center">
                            <x-button-control :type="1" href="#edit" onclick="openEditModal({{ $r->id }})"></x-button-control>
                            @if($r->app_status != 't')
                                <x-button-control :type="2" href="#destroy" :id="$r->id"></x-button-control>
                            @endif
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
    function openAddModal() {
        document.getElementById('add_staff_request').showModal();
    }
</script>

@if ($errors->insert->any())
    <input type="checkbox" id="add_staff_request" class="modal-toggle" checked />
@endif

<dialog id="add_staff_request" class="modal">
    <div class="modal-box w-8/12 max-w-3xl">
        <x-header :title="$title">
            <li>Add Data</li>
        </x-header>

        <form action="{{ route('staff_request.store') }}" method="POST">
            @csrf

            <div class="flex gap-4">

                <div class="flex-1">
                    <x-forms.fieldset label="Title" name="title" bag="insert">
                        <input type="text" id="title" name="title" class="input input-sm w-full" value="{{ old('title') }}"/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Position" name="position_id" bag="insert">
                        <select class="select select-sm w-full" id="position_id" name="position_id" >
                            <option disabled selected>- Pick a Position -</option>
                            @foreach($positions as $p)
                                <option value="{{ $p['id'] }}" {{ old('position_id') == $p['id'] ? 'selected' : '' }}>
                                    {{ $p['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Note" name="note" bag="insert">
                        <textarea class="textarea h-24 w-full" id="note" name="note">{{ old('note') }}</textarea>
                    </x-forms.fieldset>
                </div>

                <div class="flex-1">
                    <x-forms.fieldset label="Date" name="date" bag="insert">
                        <input type="date" id="date" name="date" class="input input-sm w-full" value="{{ old('date', date('Y-m-d')) }}"/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Qty" name="qty" bag="insert">
                        <input type="number" id="qty" name="qty" class="input input-sm w-[100px]" value="{{ old('qty') }}"/>
                    </x-forms.fieldset>
                </div>

            </div>

            <input type="submit" class="btn btn-sm btn-primary my-2">
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>


<script>
    function openEditModal(id) {
        fetch('/staff_request_edit/' + id + '')
            .then(response => response.json())
            .then(data => {

                data.title && (document.getElementById('edit_title').value = data.title);
                data.date && (document.getElementById('edit_date').value = data.date);
                data.qty && (document.getElementById('edit_qty').value = data.qty);
                data.note && (document.getElementById('edit_note').value = data.note);
                data.position_id && (document.getElementById('edit_position_id').value = data.position_id);

                document.getElementById('edit_form').action = '/staff_request_update/' + data.id;
                document.getElementById('edit_modal_dialog').showModal();
            });
    }
</script>

<dialog id="edit_modal_dialog" class="modal">
    <div class="modal-box w-8/12 max-w-3xl">
        <x-header :title="$title">
            <li>Edit Data</li>
        </x-header>

        <form method="POST" id="edit_form">
            @csrf

            <div class="flex gap-4">

                <div class="flex-1">
                    <x-forms.fieldset label="Title" name="title" bag="edit">
                        <input type="text" id="edit_title" name="title" class="input input-sm w-full" value="{{ old('title') }}"/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Position" name="position_id" bag="edit">
                        <select class="select select-sm w-full" id="edit_position_id" name="position_id" >
                            <option disabled selected>- Pick a Position -</option>
                            @foreach($positions as $p)
                                <option value="{{ $p['id'] }}" {{ old('position_id') == $p['id'] ? 'selected' : '' }}>
                                    {{ $p['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Note" name="note" bag="edit">
                        <textarea class="textarea h-24 w-full" id="edit_note" name="note">{{ old('note') }}</textarea>
                    </x-forms.fieldset>
                </div>

                <div class="flex-1">
                    <x-forms.fieldset label="Date" name="date" bag="edit">
                        <input type="date" id="edit_date" name="date" class="input input-sm w-full" value="{{ old('date', date('Y-m-d')) }}"/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Qty" name="qty" bag="edit">
                        <input type="number" id="edit_qty" name="qty" class="input input-sm w-[100px]" value="{{ old('qty') }}"/>
                    </x-forms.fieldset>
                </div>

            </div>

            <input type="submit" class="btn btn-sm btn-primary my-2">
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>Close</button>
    </form>
</dialog>

@if (session('edit_id'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            openEditModal({{ session('edit_id') }});
        });
    </script>
@endif

<script>
    function openApproveModal(id) {
        fetch('/staff_request_approve/' + id + '')
            .then(response => response.json())
            .then(data => {

                data.app_by && (document.getElementById('app_by').value = data.app_by.name);
                data.app_date && (document.getElementById('app_date').value = data.app_date);

                let statusRadios = document.getElementsByName('app_status');
                statusRadios.forEach(radio => {
                    if (radio.value === data.app_status) {
                        radio.checked = true;
                    }
                });
                document.getElementById('app_note').value = data.app_note;

                document.getElementById('app_form').action = '/staff_request_update_appr/' + data.id;
                document.getElementById('app_modal_dialog').showModal();
            });
    }
</script>

<dialog id="app_modal_dialog" class="modal">
    <div class="modal-box w-5/12 ">
        <x-header :title="$title">
            <li>Approve Data</li>
        </x-header>

        <form method="POST" id="app_form">
            @csrf

            <x-forms.fieldset label="By" name="app_by" bag="approve">
                <input type="text" id="app_by" class="input input-sm w-full" value="{{ old('app_by', auth()->user()->name) }}" disabled/>
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
