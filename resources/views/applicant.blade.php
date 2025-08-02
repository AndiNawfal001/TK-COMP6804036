<x-layout>
    <x-header :title="$title"></x-header>
    @if (session('success'))
        <x-alert-top></x-alert-top>
    @endif

    <div class="flex justify-between mb-2">
        <form>
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
                <th width="50"></th>
                <th width="*">Name</th>
                <th width="200">Telephone</th>
                <th width="200">Email</th>
                <th width="150">Input Date</th>
                <th width="150">Status</th>
                <th width="200">Applicant Number</th>
                <th width="100" align="center">Control</th>
            </tr>
            </thead>
            <tbody>
            @forelse($datas as $no => $r)

                @php
                    if (empty($r->applicants)) {
                        $color = 'badge-warning';
                        $status = 'Incomplete';
                    } else {
                        $color = 'badge-info';
                        $status = 'Complete';
                    }
                @endphp
                <tr>
                    <th align="center">{{ $datas->firstItem() + $no }}.</th>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->telephone }}</td>
                    <td>{{ $r->email }}</td>
                    <td>{{ $r->created_at ? date('j F Y', strtotime($r->created_at)) : '-' }}</td>
                    <td>
                        <div class="badge badge-sm badge-soft {{ $color }}">{{ $status }}</div>
                    </td>
                    <td>{{ optional($r->applicants)->applicant_number ?? '-' }}</td>
                    <td align="center">
                        <x-button-control :type="3" href="#edit" onclick="openEditModal({{ $r->id }})"></x-button-control>
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
        fetch('/applicants_detail/' + id)
            .then(response => response.json())
            .then(data => {
                const applicant = data.data;
                const user = data.user

                console.log(applicant);

                if (user) {
                    document.getElementById('name').value = user.name ?? '';
                    document.getElementById('telephone').value = user.telephone ?? '';
                    document.getElementById('email').value = user.email ?? '';
                }

                if (applicant) {
                    document.getElementById('birth_place').value = applicant.birth_place ?? '';
                    document.getElementById('birth_date').value = applicant.birth_date ?? '';
                    document.getElementById('last_edu').value = applicant.last_edu ?? '';
                    document.getElementById('religion').value = applicant.religion ?? '';
                    document.getElementById('height').value = applicant.height ?? '';
                    document.getElementById('weight').value = applicant.weight ?? '';
                    document.getElementById('address').value = applicant.address ?? '';

                    const genderRadio = document.querySelector(`input[name="gender"][value="${applicant.gender}"]`);
                    if (genderRadio) genderRadio.checked = true;

                    if (applicant.applicant_number) {
                        const applicantNumberInput = document.getElementById('applicant_number');
                        if (applicantNumberInput) {
                            applicantNumberInput.value = applicant.applicant_number;
                        }
                    }

                    const photoDisplay = document.getElementById('photo_display');
                    photoDisplay.innerHTML = '';
                    if (applicant.photo) {
                        photoDisplay.innerHTML = `
                            <a href="/storage/${applicant.photo}" target="_blank" class="btn btn-soft btn-sm btn-square btn-info">
                                <i class="fi fi-sr-file"></i>
                            </a>
                        `;
                    } else {
                        photoDisplay.innerHTML = `<span class="text-sm text-gray-500">Photo not yet uploaded</span>`;
                    }

                    const cvDisplay = document.getElementById('cv_display');
                    cvDisplay.innerHTML = '';
                    if (applicant.cv) {
                        cvDisplay.innerHTML = `
                            <a href="/storage/${applicant.cv}" target="_blank" class="btn btn-soft btn-sm btn-square btn-info">
                                <i class="fi fi-sr-file"></i>
                            </a>
                        `;
                    } else {
                        cvDisplay.innerHTML = `<span class="text-sm text-gray-500">CV not yet uploaded</span>`;
                    }

                    const ktpDisplay = document.getElementById('ktp_display');
                    ktpDisplay.innerHTML = '';
                    if (applicant.ktp) {
                        ktpDisplay.innerHTML = `
                            <a href="/storage/${applicant.ktp}" target="_blank" class="btn btn-soft btn-sm btn-square btn-info">
                                <i class="fi fi-sr-file"></i>
                            </a>
                        `;
                    } else {
                        ktpDisplay.innerHTML = `<span class="text-sm text-gray-500">CV not yet uploaded</span>`;
                    }

                }

                document.getElementById('detail_modal_dialog').showModal();
            })
            .catch(error => {
                console.error('Error fetching applicant data:', error);
            });
    }
</script>


<dialog id="detail_modal_dialog" class="modal">
    <div class="modal-box w-11/12 lg:w-8/12 max-w-3xl">
        <x-header :title="$title">
            <li>Approve Data</li>
        </x-header>


        <form method="POST" id="app_form" enctype="multipart/form-data">
            @csrf

            <div class="lg:flex gap-4">
                <div class="flex-1">
                    <x-forms.fieldset label="Full Name" name="name" bag="edit">
                        <input type="text" id="name" name="name" class="input input-sm w-full" disabled/>
                    </x-forms.fieldset>

                    @if(isset($data->applicant_number))
                        <x-forms.fieldset label="Applicant Number" name="applicant_number" bag="edit">
                            <input type="text" id="applicant_number" name="applicant_number" class="input input-sm w-full" disabled/>
                        </x-forms.fieldset>
                    @endif

                    <x-forms.fieldset label="Telephone" name="telephone" bag="edit">
                        <input type="text" id="telephone" name="telephone" class="input input-sm w-full" disabled/>
                    </x-forms.fieldset>

                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Gender</legend>
                        <div class="flex gap-2">
                            <input type="radio" id="gender" name="gender" value="m" class="radio radio-sm radio-sm radio-info" disabled/> <span class="text-sm">Male</span>
                            <input type="radio" id="gender" name="gender" value="f" class="radio radio-sm radio-sm radio-secondary" disabled/> <span class="text-sm">Female</span>
                        </div>
                    </fieldset>

                    <x-forms.fieldset label="Place & Date of Birth" name="place_date_birth" bag="edit">
                        <div class="flex items-center gap-2">
                            <input type="text" id="birth_place" name="birth_place" class="input input-sm w-[150px]" disabled/>

                            <input type="date" id="birth_date" name="birth_date" class="input input-sm w-[200px]" disabled/>
                        </div>
                    </x-forms.fieldset>


                    <x-forms.fieldset label="Lastest Education" name="last_edu" bag="edit">
                        <select class="select select-sm w-full" id="last_edu" name="last_edu" disabled>
                            <option disabled selected>- Pick a Education -</option>
                            @foreach($educations as $e)
                                <option value="{{ $e['id'] }}">
                                    {{ $e['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Religion" name="religion" bag="edit">
                        <select class="select select-sm w-full" id="religion" name="religion" disabled>
                            <option disabled selected>- Pick a Religion -</option>
                            @foreach($religions as $e)
                                <option value="{{ $e['id'] }}">
                                    {{ $e['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </x-forms.fieldset>
                </div>
                <div class="flex-1">

                    <x-forms.fieldset label="Email" name="email" bag="edit">
                        <input type="text" id="email" name="email" class="input input-sm w-full" disabled/>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Height & Weight" name="height_weith" bag="edit">
                        <div class="flex items-center gap-2">
                            <input type="number" id="height" name="height" class="input input-sm w-[100px]" placeholder="Height (cm)" disabled/>
                            &
                            <input type="number" id="weight" name="weight" class="input input-sm w-[100px]" placeholder="Weight (kg)" disabled/>
                        </div>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Upload Photo" name="photo" bag="edit">
                        <div class="flex gap-2">
                            <div id="photo_display"></div>
                        </div>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Upload CV" name="cv" bag="edit">
                        <div class="flex gap-2">
                            <div id="cv_display"></div>
                        </div>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Upload KTP (Indonesian ID Card)" name="ktp" bag="edit">
                        <div class="flex gap-2">
                            <div id="ktp_display"></div>
                        </div>
                    </x-forms.fieldset>

                    <x-forms.fieldset label="Address" name="address" bag="edit">
                        <textarea class="textarea h-24 w-full" id="address" name="address" disabled></textarea>
                    </x-forms.fieldset>
                </div>
            </div>


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
