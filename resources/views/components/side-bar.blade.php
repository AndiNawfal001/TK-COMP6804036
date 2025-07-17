<label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
<ul class="menu bg-base-100 text-base-content min-h-full w-80 p-4 ">
    <x-nav-link href="/dashboard" :active="request()->is('dashboard')" >Dashboard</x-nav-link>
    @can('admin')
        <x-nav-link href="/staff_request" :active="request()->is('staff_request')" >Staff Requests</x-nav-link>
        <x-nav-link href="/vacancies" :active="request()->is('vacancies')" >Vacancies</x-nav-link>
    @endcan

    @can('applicant')
        <x-nav-link href="/select_vacancies" :active="request()->is('select_vacancies')" >Select vacancies</x-nav-link>
    @endcan

    @php
        $isActive = request()->is('selection/*');
    @endphp

    <li>
        <a href="javascript:void(0);" onclick="toggleSelectionMenu()" class="cursor-pointer">Selections</a>
        <ul id="selection-menu" class="p-2 {{ $isActive ? '' : 'hidden' }}">
            <x-nav-link href="/selection/1" :active="request()->is('selection/1')">Document Check</x-nav-link>
            <x-nav-link href="/selection/2" :active="request()->is('selection/2')">Written Test</x-nav-link>
            <x-nav-link href="/selection/3" :active="request()->is('selection/3')">Initial Interview</x-nav-link>
            <x-nav-link href="/selection/4" :active="request()->is('selection/4')">Technical Interview</x-nav-link>
            <x-nav-link href="/selection/5" :active="request()->is('selection/5')">Psychological Test</x-nav-link>
            <x-nav-link href="/selection/6" :active="request()->is('selection/6')">Final Interview</x-nav-link>
            <x-nav-link href="/selection/7" :active="request()->is('selection/7')">Medical Checkup</x-nav-link>
        </ul>
    </li>
    <script>
        function toggleSelectionMenu() {
            const menu = document.getElementById('selection-menu');
            menu.classList.toggle('hidden');
        }
    </script>

    @can('admin')
        <x-nav-link href="/appointments" :active="request()->is('appointmens')" >Appointments</x-nav-link>
    @endcan
</ul>
