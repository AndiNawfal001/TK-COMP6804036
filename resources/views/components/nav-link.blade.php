@props(['active' => false])

<li><a {{ $attributes  }} class="{{ $active ? 'bg-neutral text-white' : ''  }}">{{ $slot }}</a></li>
