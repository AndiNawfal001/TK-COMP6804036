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
        </form>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @php
            $color = ['accent', 'info', 'primary', 'secondary', 'success'];
        @endphp
        @forelse($datas as $r)
            <a href="#" onclick="openDetail({{ $r->id }})">
                <div class="card w-full bg-base-100 card-sm shadow-sm hover:shadow-md">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <h2 class="card-title">{{ $r->title }}</h2>
                            <span>{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="badge badge-xs badge-outline badge-primary">{{ $r->staff_request->position->name }}</span>
                            <span class="badge badge-xs badge-outline badge-error">{{ $r->countApplicantsByType(1) }} / {{ $r->staff_request->qty }}</span>
                        </div>
                        <p>{{ $r->note }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div role="alert" class="alert alert-info alert-soft">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>No Data available</span>
            </div>
        @endforelse
    </div>
    {{ $datas->links('vendor.pagination.tailwind') }}

</x-layout>

<script>
    function openDetail(id) {
        fetch('/select_vacancies_detail/' + id + '')
            .then(response => response.json())
            .then(data => {

                document.getElementById('apply_vacancy_id').value  = id;
                data.title && (document.getElementById('detail_title').textContent  = data.title);
                data.staff_request && (document.getElementById('detail_position').textContent  = data.staff_request.position.name);
                data.min_age && (document.getElementById('detail_min_age').textContent  = data.min_age);
                data.max_age && (document.getElementById('detail_max_age').textContent  = data.max_age);
                data.sallary && (document.getElementById('detail_sallary').textContent  = data.sallary);
                data.sallary_id && (document.getElementById('detail_sallary_id').textContent  = data.sallary_id.name);
                data.note && (document.getElementById('detail_note').textContent  = data.note);

                document.getElementById('detail_modal_dialog').showModal();
            });
    }
</script>

<dialog id="detail_modal_dialog" class="modal">
    <div class="modal-box w-11/12 md:8/12 max-w-3xl">

        <h2 class="text-xl font-semibold">Vacancy Detail</h2>
        <div class="divider"></div>

        <div class="space-y-2 text-sm">
            <div>
                <span class="font-semibold">Title :</span>
                <span id="detail_title" class="text-base ml-1">-</span>
            </div>
            <div>
                <span class="font-semibold">Position :</span>
                <span id="detail_position" class="ml-1">-</span>
            </div>
            <div>
                <span class="font-semibold">Minimum Age :</span>
                <span id="detail_min_age" class="ml-1">-</span>
            </div>
            <div>
                <span class="font-semibold">Maximum Age :</span>
                <span id="detail_max_age" class="ml-1">-</span>
            </div>
            <div>
                <span class="font-semibold">Sallary :</span>
                <span id="detail_sallary" class="ml-1">-</span>
            </div>
            <div>
                <span class="font-semibold">Sallary Type :</span>
                <span id="detail_sallary_id" class="ml-1">-</span>
            </div>
            <div>
                <span class="font-semibold">Notes :</span>
                <span id="detail_note" class="ml-1">-</span>
            </div>
        </div>

        <div class="divider"></div>

        @if($status_check == 'active')

            <div role="alert" class="alert alert-warning alert-soft">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>You already have an active selection process. Please complete it or wait until it finishes.</span>
            </div>

        @else

            <div role="alert" class="alert alert-success alert-soft">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold">You’re about to apply for this vacancy</h3>
                    <div class="text-xs">Your uploaded CV and other documents will be included in this application.</div>
                </div>
            </div>

        @endif


        <form method="POST" id="detail_form" action="{{ route('select_vacancies.store') }}">
            @csrf
            <input type="hidden" name="vacancy_id" id="apply_vacancy_id">
            <div class="mt-4 flex justify-end gap-2 ">
                <button type="submit" class="btn btn-primary" {{ ($status_check != 'ready') ? "disabled" : "" }}>Confirm & Apply</button>
            </div>
        </form>

    </div>
    <form method="dialog" class="modal-backdrop">
        <button>Close</button>
    </form>
</dialog>


@if (session('detail_id'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            openDetail({{ session('detail_id') }});
        });
    </script>
@endif
