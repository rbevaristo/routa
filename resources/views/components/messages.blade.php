@if($errors->any())
    @foreach($errors->all() as $error)
        @php
            echo '<script> toastr.error("'.$error.'") </script>';  
        @endphp
    @endforeach
@endif