<?php
if($slot == 't'){
    $value = 'Completed';
    $color = 'badge-accent';
}elseif($slot == 'f'){
    $value = 'Cancelled';
    $color = 'badge-error';
}elseif($slot == 'p'){
    $value = 'Scheduled';
    $color = 'badge-warning';
}
?>

@if($slot != '')
    <div class="badge badge-sm badge-soft hover:shadow-sm {{ $color }}"  onclick="{{ $onclick }}"><a href="{{ $href }}">{{ $value }}</a></div>
@endif
