<div class="navbar bg-base-100 shadow-sm">
    <div class="flex-1">
        <label for="my-drawer-2" class="btn btn-neutral drawer-button lg:hidden">
            &raquo;
        </label>
        <a class="btn btn-ghost text-xl">Rekrutin.</a>

    </div>
    <div class="flex-none">

        <div class="dropdown dropdown-end">

            <label class="toggle text-base-content">
                <input type="checkbox" value="synthwave" class="theme-controller"  data-toggle-theme="dark,light" data-act-class="ACTIVECLASS"  />

                <svg aria-label="sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></g></svg>

                <svg aria-label="moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></g></svg>

            </label>
        </div>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">

                <div class="w-10 rounded-full">
                    <img
                        alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
{{--                    <img src="{{ asset('storage/' . auth()->user()->applicants->photo) }}" />--}}
                </div>
            </div>
            <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        {{ auth()->user()->name }}
                    </a>
                </li>
                <li><a>Settings</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>
