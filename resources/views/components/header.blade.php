<h2 class="font-bold text-xl ">{{ $title }}</h2>
<div class="breadcrumbs text-sm -mt-2">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="{{ request()->getRequestUri() }}">{{ $title }}</a></li>
        {{ $slot }}
    </ul>
</div>
