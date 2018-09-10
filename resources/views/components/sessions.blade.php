@if(session('error'))
    @php
        echo '<script> toastr.error("'.session("error").'")</script>';
    @endphp
@elseif(session('success'))
    @php
        echo '<script> toastr.success("'.session("success").'")</script>';
    @endphp
@endif