<label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
<ul class="menu bg-base-100 text-base-content min-h-full w-80 p-4 ">
    <x-nav-link href="/dashboard" :active="request()->is('dashboard')" >Dashboard</x-nav-link>
    <x-nav-link href="/staff_request" :active="request()->is('staff_request')" >Staff Requests</x-nav-link>
    <x-nav-link href="/vacancies" :active="request()->is('vacancies')" >Vacancies</x-nav-link>
    <x-nav-link href="/applicant" :active="request()->is('applicant')" >Applicants</x-nav-link>

    <li>
        <a>Selections</a>
        <ul class="p-2">
            <li><a>Aptitude Test</a></li>
            <li><a>Psychological Test</a></li>
            <li><a>Medical and Physical Test</a></li>
        </ul>
    </li>

    @can('admin-cuy')
        <x-nav-link href="/interviews" :active="request()->is('interviews')" >Interviews</x-nav-link>
    @endcan
    <x-nav-link href="/appointmens" :active="request()->is('appointmens')" >Appointmens</x-nav-link>
</ul>
