<x-layout>
    <x-header :title="$title"></x-header>
    @if (session('success'))
        <x-alert-top></x-alert-top>
    @endif

    <form method="POST" id="app_form" enctype="multipart/form-data">
        @csrf

        <div class="lg:flex gap-4">
            <div class="flex-1">
                <x-forms.fieldset label="Full Name" name="name" bag="edit">
                    <input type="text" id="name" name="name" class="input input-sm w-full" value="{{ old('app_by', auth()->user()->name) }}" readonly/>
                </x-forms.fieldset>

                <x-forms.fieldset label="Telephone" name="telephone" bag="edit">
                    <input type="text" id="telephone" name="telephone" class="input input-sm w-full" value="{{ old('app_by', auth()->user()->telephone) }}" readonly/>
                </x-forms.fieldset>

                <x-forms.fieldset label="Email" name="email" bag="edit">
                    <input type="text" id="email" name="email" class="input input-sm w-full" value="{{ old('app_by', auth()->user()->email) }}" readonly/>
                </x-forms.fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Gender</legend>
                    <div class="flex gap-2">
                        <input type="radio" id="gender" name="gender" value="m" class="radio radio-sm radio-sm radio-info" {{ old('gender', $data->gender ?? '') == 'm' ? 'checked' : '' }}/> <span class="text-sm">Male</span>
                        <input type="radio" id="gender" name="gender" value="f" class="radio radio-sm radio-sm radio-secondary" {{ old('gender', $data->gender ?? '') == 'f' ? 'checked' : '' }}/> <span class="text-sm">Female</span>
                    </div>
                </fieldset>

                <x-forms.fieldset label="Place & Date of Birth" name="place_date_birth" bag="edit">
                    <div class="flex items-center gap-2">
                        <input type="text" id="birth_place" name="birth_place" class="input input-sm w-[150px]" value="{{ old('birth_place', $data->birth_place ?? '') }}" required/>

                        <input type="date" id="birth_date" name="birth_date" class="input input-sm w-[200px]" value="{{ old('birth_date', $data->birth_date ?? '') }}"/>
                    </div>
                </x-forms.fieldset>


                <x-forms.fieldset label="Lastest Education" name="last_edu" bag="edit">
                    <select class="select select-sm w-full" id="last_edu" name="last_edu" >
                        <option disabled selected>- Pick a Education -</option>
                        @foreach($educations as $e)
                            <option value="{{ $e['id'] }}" {{ old('last_edu', $data->last_edu ?? '') == $e['id'] ? 'selected' : '' }}>
                                {{ $e['name'] }}
                            </option>
                        @endforeach
                    </select>
                </x-forms.fieldset>

                <x-forms.fieldset label="Religion" name="religion" bag="edit">
                    <select class="select select-sm w-full" id="religion" name="religion" >
                        <option disabled selected>- Pick a Religion -</option>
                        @foreach($religions as $e)
                            <option value="{{ $e['id'] }}" {{ old('religion', $data->religion ?? '') == $e['id'] ? 'selected' : '' }}>
                                {{ $e['name'] }}
                            </option>
                        @endforeach
                    </select>
                </x-forms.fieldset>
            </div>
            <div class="flex-1">

                <x-forms.fieldset label="Height & Weight" name="height_weith" bag="edit">
                    <div class="flex items-center gap-2">
                        <input type="number" id="height" name="height" class="input input-sm w-[100px]" value="{{ old('height', $data->height ?? '') }}" required placeholder="Height (cm)"/>
                        &
                        <input type="number" id="weight" name="weight" class="input input-sm w-[100px]" value="{{ old('weight', $data->weight ?? '') }}" required placeholder="Weight (kg)"/>
                    </div>
                </x-forms.fieldset>

                <x-forms.fieldset label="Upload Photo" name="photo" bag="edit">
                    <input type="file" id="photo" name="photo" class="file-input file-input-sm" />

                    @if(optional($data)->photo)
                        <a href="{{ asset('storage/' . $data->photo) }}" target="_blank" class="link link-primary">
                            View File
                        </a>
                    @endif

                </x-forms.fieldset>

                <x-forms.fieldset label="Upload CV" name="cv" bag="edit">
                    <input type="file" id="cv" name="cv" class="file-input file-input-sm" />
                </x-forms.fieldset>

                <x-forms.fieldset label="Upload KTP (Indonesian ID Card)" name="ktp" bag="edit">
                    <input type="file" id="ktp" name="ktp" class="file-input file-input-sm" />
                </x-forms.fieldset>

                <x-forms.fieldset label="Address" name="address" bag="edit">
                    <textarea class="textarea h-24 w-full" id="address" name="address">{{ old('address') }}</textarea>
                </x-forms.fieldset>

            </div>
        </div>


        <input type="submit" class="btn btn-sm btn-primary my-2" value="Save Changes">
    </form>

</x-layout>
