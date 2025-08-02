@if($attributes['type'] == 1)
    <button class="btn btn-xs btn-circle btn-outline btn-warning"  onclick="{{ $onclick }}">
        <a href="{{ $href }}"><i class="fi fi-sr-pencil"></i></a>
    </button>
@elseif($attributes['type'] == 2)
    <form id="delete-form-{{ $id }}" action="{{ route('staff_request_destroy', $id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
    </form>

    <button type="button" class="btn btn-xs btn-circle btn-outline btn-error" onclick="confirmDelete({{ $id }})">
        <i class="fi fi-sr-trash"></i>
    </button>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete this data?',
                text: "This action cannot be undone.",
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-lg p-5',
                    confirmButton: 'btn btn-sm btn-error mx-2',
                    cancelButton: 'btn btn-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

    </script>
@elseif($attributes['type'] == 3)
    <button class="btn btn-xs btn-circle btn-outline btn-info"  onclick="{{ $onclick }}">
        <a href="{{ $href }}"><i class="fi fi-sr-file"></i></a>
    </button>
@endif
