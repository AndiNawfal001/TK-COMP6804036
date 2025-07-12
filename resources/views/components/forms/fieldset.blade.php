<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    {{ $slot }}
    @error($name, $bag)
    <p class="label text-red-400">{{ $message }}</p>
    @enderror
</fieldset>
