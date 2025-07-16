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
                            <span class="badge badge-xs badge-outline badge-error">0 / {{ $r->staff_request->qty }}</span>
                        </div>
                        <p>{{ $r->note }}</p>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="card w-full bg-base-100 card-sm shadow-sm hover:shadow-md">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <h2 class="card-title">{{ $r->title }}</h2>
                            <span>{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="badge badge-xs badge-outline badge-primary">{{ $r->staff_request->position->name }}</span>
                            <span class="badge badge-xs badge-outline badge-error">0 / {{ $r->staff_request->qty }}</span>
                        </div>
                        <p>{{ $r->note }}</p>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="card w-full bg-base-100 card-sm shadow-sm hover:shadow-md">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <h2 class="card-title">{{ $r->title }}</h2>
                            <span>{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="badge badge-xs badge-outline badge-primary">{{ $r->staff_request->position->name }}</span>
                            <span class="badge badge-xs badge-outline badge-error">0 / {{ $r->staff_request->qty }}</span>
                        </div>
                        <p>{{ $r->note }}</p>
                    </div>
                </div>
            </a>
        @empty
            no
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

                document.getElementById('detail_form').action = '/select_vacancies_update/' + data.id;
                document.getElementById('detail_modal_dialog').showModal();
            });
    }
</script>

<dialog id="detail_modal_dialog" class="modal">
    <div class="modal-box w-11/12 md:8/12 max-w-3xl">

        <h2 class="text-2xl font-semibold">Vacancy Detail</h2>
        <div class="divider"></div>

        <div class="space-y-2">
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

        <div class="bg-accent text-accent-content p-4 rounded-lg mb-4">
            <p class="text-lg font-medium mb-2">You’re about to apply for this vacancy </p>
            <p class="mt-2 text-sm">Your uploaded CV and other documents will be included in this application.</p>
        </div>

        <form method="POST" id="detail_form">
            @csrf
            <input type="hidden" name="vacancy_id" id="apply_vacancy_id">
            <div class="mt-4 flex justify-end gap-2 ">
                <button type="submit" class="btn btn-primary">Confirm & Apply</button>
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
