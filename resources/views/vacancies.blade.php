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
                    <th width="100">Number Request</th>
                    <th width="*">Title</th>
                    <th width="150">Input Date</th>
                    <th width="150">Position</th>
                    <th width="20">Filled</th>
                    <th width="50">Status</th>
                    <th width="80">Control</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datas as $no => $r)
                    @php
                        if($r->status == 't'){
                            $value = 'Publish';
                            $color = 'badge-primary';
                        }elseif($r->status == 'f'){
                            $value = 'Unpublish';
                            $color = 'badge-info';
                        }
                    @endphp
                    <tr>
                        <th align="center">{{ $datas->firstItem() + $no }}.</th>
                        <td>{{ $r->staff_request->number }}</td>
                        <td>{{ $r->title }}</td>
                        <td>{{ date('j F Y', strtotime($r->date )) }}</td>
                        <td>{{ $r->staff_request->position->name }}</td>
                        <td align="center">{{ $r->staff_request->qty }}</td>
                        <td>
                            <div class="badge badge-sm badge-soft {{ $color }}">{{ $value }}</div>
                        </td>
                        <td align="center">
                            <x-button-control :type="1" href="#edit" onclick="openEditModal({{ $r->id }})"></x-button-control>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="9">
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
        {{ $datas->links('vendor.pagination.tailwind') }}

    </div>

</x-layout>

<script>
    function openEditModal(id) {
        fetch('/vacancies_edit/' + id + '')
            .then(response => response.json())
            .then(data => {

                data.title && (document.getElementById('edit_title').value = data.title);
                data.position && (document.getElementById('edit_position').value = data.position);
                data.note && (document.getElementById('edit_note').value = data.note);
                data.min_age && (document.getElementById('edit_min_age').value = data.min_age);
                data.max_age && (document.getElementById('edit_max_age').value = data.max_age);

                data.min_edu && (document.getElementById('edit_min_edu').value = data.min_edu.id);
                data.sallary_id && (document.getElementById('edit_sallary_id').value = data.sallary_id.id);

                data.sallary && (document.getElementById('edit_sallary').value = data.sallary);
                if (data.status) {
                    document.getElementById('edit_status').checked = (data.status === 't');
                }

                document.getElementById('edit_form').action = '/vacancies_update/' + data.id;
                document.getElementById('edit_modal_dialog').showModal();
            });
    }
    function formatPrice(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value.length === 0) {
            input.value = '';
            return;
        }
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<dialog id="edit_modal_dialog" class="modal">
    <div class="modal-box w-8/12 max-w-3xl">
        <x-header :title="$title">
            <li>Edit Data</li>
        </x-header>

        <form method="POST" id="edit_form">
            @csrf
            @if ($errors->edit->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->edit->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex gap-4">

                <div class="flex-1">
                    <x-forms.fieldset label="Title" name="title" bag="edit">
                        <input type="text" id="edit_title" name="title" class="input input-sm w-full" value="{{ old('title') }}"/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Position" name="position" bag="edit">
                        <input type="text" id="edit_position" name="position" class="input input-sm w-full" value="{{ old('position') }}" disabled/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Note" name="note" bag="edit">
                        <textarea class="textarea h-40 w-full" id="edit_note" name="note">{{ old('note') }}</textarea>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Status Publish" name="status" bag="edit">
                        <input type="checkbox" id="edit_status" name="status" value="t" checked="checked" class="toggle toggle-sm toggle-primary" />
                    </x-forms.fieldset>
                </div>

                <div class="flex-1">
                    <x-forms.fieldset label="Age" name="age" bag="edit">
                        <div class="flex items-center gap-2">
                            <input type="number" id="edit_min_age" name="min_age" class="input input-sm w-[100px]" value="{{ old('min_age') }}" required/>
                            until
                            <input type="number" id="edit_max_age" name="max_age" class="input input-sm w-[100px]" value="{{ old('max_age') }}" required/>
                        </div>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Minimum Education" name="min_edu" bag="edit">
                        <select class="select select-sm w-full" id="edit_min_edu" name="min_edu" >
                            <option disabled selected>- Pick a Education -</option>
                            @foreach($educations as $e)
                                <option value="{{ $e['id'] }}" {{ old('min_edu') == $e['id'] ? 'selected' : '' }}>
                                    {{ $e['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Sallary Type" name="sallary_id" bag="edit">
                        <select class="select select-sm w-full" id="edit_sallary_id" name="sallary_id" >
                            <option disabled selected>- Pick a Salarry Type -</option>
                            @foreach($sallary_types as $s)
                                <option value="{{ $s['id'] }}" {{ old('sallary_id') == $s['id'] ? 'selected' : '' }}>
                                    {{ $s['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Sallary" name="sallary" bag="edit">
                        <div class="flex items-center gap-2">
                            <input type="text" id="edit_sallary" name="sallary" class="input input-sm w-1/2"  onkeyup="formatPrice(this)" value="{{ old('sallary') }}"/>
                        </div>
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
        fetch('/vacancies_approve/' + id + '')
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

                document.getElementById('app_form').action = '/vacancies_update_appr/' + data.id;
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
                <input type="text" id="app_by" class="input w-full" value="{{ old('app_by', auth()->user()->name) }}" disabled/>
            </x-forms.fieldset>

            <x-forms.fieldset label="Date" name="app_date" bag="approve">
                <input type="date" id="app_date" name="app_date" class="input w-full" value="{{ old('app_date', date('Y-m-d')) }}"/>
            </x-forms.fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Page title</legend>
                <div class="flex gap-2">
                    <input type="radio" id="app_status" name="app_status" value="t" class="radio radio-sm radio-accent" /> <span class="text-sm">Approve</span>
                    <input type="radio" id="app_status" name="app_status" value="p" class="radio radio-sm radio-warning" /> <span class="text-sm">Pending</span>
                    <input type="radio" id="app_status" name="app_status" value="f" class="radio radio-sm radio-error" /> <span class="text-sm">Reject</span>
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
