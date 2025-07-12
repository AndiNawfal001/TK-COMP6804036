<?php
    if($slot == 't'){
        $value = 'Approved';
        $color = 'badge-accent';
    }elseif($slot == 'f'){
        $value = 'Rejected';
        $color = 'badge-error';
    }elseif($slot == 'p'){
        $value = 'Pending';
        $color = 'badge-warning';
    }
?>

@if($slot != '')
    <div class="badge badge-sm badge-soft hover:shadow-sm {{ $color }}"  onclick="{{ $onclick }}"><a href="{{ $href }}">{{ $value }}</a></div>
@endif
