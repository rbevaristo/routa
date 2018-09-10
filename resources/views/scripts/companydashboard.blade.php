<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(".modal").on("hidden.bs.modal", function(){
            location.reload();
        });

        $('input[type="checkbox"].act').on('change', function() {
            if ($(this).is(':checked')){ 
                var url = "{{ route('manager.update') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id : $(this).val(),
                        status: 1
                    },
                    success: function (result) {
                        toastr.info('Employee activated');
                    },
                });
            } 
            else { 
                var url = "{{ route('manager.update') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id : $(this).val(),
                        status: 0
                    },
                    success: function (result) {
                        toastr.warning('Employee deactivated');
                    }
                });
            }
        });
        
        $('a.profile').on('click', function(){
            let id = $(this).attr('id');
            var url = "{{ url('/dashboard/manager/') }}"+"/"+id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function (result) {
                    $('.modal .modal-header').html('');
                    $('.modal .modal-body').html('');
                    $('.modal .modal-header').html(`
                        Employee Profile
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    `);
                    $('.modal .modal-body').html(
                        `
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="author text-center">
                                                <a href="#">
                                                    <img class="avatar border-gray" src="{{ asset('storage/images/') }}/`+result.data.profile.avatar+`" alt="Avatar" width="70" height="70">
                                                    <h5 class="name">`+result.data.name+`</h5>
                                                </a>
                                                <p class="text-black">`+check(result.data.email)+`</p>
                                                <p class="text-black">`+result.data.username+`</p>                                  
                                                <p class="text-black">`+result.data.position+`</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Personal Information</div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td>
                                                            `+checkGender(result.data.profile.gender)+`
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Birthday</td>
                                                        <td>
                                                            `+check(result.data.profile.birthdate)+`
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact</td>
                                                        <td>
                                                            `+check(result.data.profile.contact)+`
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td>
                                                            `+check(result.data.address.number)+`
                                                            `+check(result.data.address.street)+`
                                                            `+check(result.data.address.city)+`
                                                            `+check(result.data.address.state)+`
                                                            `+check(result.data.address.zip)+`
                                                            `+check(result.data.address.country)+`
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="evaluation_files">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Evaluation</div>
                                        <div class="card-body" style="height: 300px; overflow-y: auto;">
                                            <div class="row text-center">
                                                <p>Evaluations are inactive to the employees, click the checkbox to activate and it will be visible to the employees.</p>    
                                            </div>
                                            <hr>
                                            `+getEvaluation(result.evaluation)+`
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                    );
                },
            });
        });

        $('a.eprofile').on('click', function(){
            let id = $(this).attr('id');
            var url = "{{ url('/dashboard/employee/') }}"+"/"+id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function (result) {
                    $('.modal .modal-header').html('');
                    $('.modal .modal-body').html('');
                    $('.modal .modal-header').html(`
                        Employee Profile
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    `);
                    $('.modal .modal-body').html(
                        `
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="author text-center">
                                                <a href="#">
                                                    <img class="avatar border-gray" src="{{ asset('storage/images/') }}/`+result.data.profile.avatar+`" alt="Avatar" width="70" height="70">
                                                    <h5 class="name">`+result.data.name+`</h5>
                                                </a>
                                                <p class="text-black">`+check(result.data.email)+`</p>
                                                <p class="text-black">`+result.data.username+`</p>                                  
                                                <p class="text-black">`+result.data.position+`</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Personal Information</div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td>
                                                            `+checkGender(result.data.profile.gender)+`
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Birthday</td>
                                                        <td>
                                                            `+check(result.data.profile.birthdate)+`
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact</td>
                                                        <td>
                                                            `+check(result.data.profile.contact)+`
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td>
                                                            `+check(result.data.address.number)+`
                                                            `+check(result.data.address.street)+`
                                                            `+check(result.data.address.city)+`
                                                            `+check(result.data.address.state)+`
                                                            `+check(result.data.address.zip)+`
                                                            `+check(result.data.address.country)+`
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="evaluation_files">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Evaluation</div>
                                        <div class="card-body" style="height: 300px; overflow-y: auto;">
                                            <div class="row text-center">
                                                <p>Evaluations are inactive to the employees, click the checkbox to activate and it will be visible to the employees.</p>    
                                            </div>
                                            <hr>
                                            `+getEvaluation(result.evaluation)+`
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                    );
                },
            });
        });
        function check(value){
            if(value == null)
                return "";
            return value;
        }

        function checkGender(value){
            if(value == null)
                return "";
            return (value == 1) ? "Male" : "Female";
        }

        function getEvaluation(evaluations){ 
            var data = '';
            var keys = Object.keys(evaluations);
            if(keys.length > 0){
                for(var i = 0; i < keys.length; i++){
                    var d = new Date(evaluations[i].created_at);
                    var date = (d.getMonth()+1) + '/' + d.getDate() +'/'+ d.getFullYear();
                    data += `
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ asset('storage/pdf/') }}/`+evaluations[i].filename+`" target="_blank"> 
                                    `+evaluations[i].filename+`
                                </a>
                            </div>
                            <div class="col-3">
                                `+date+`
                            </div>`;
                    if(evaluations[i].active){
                        data += `
                            <div class="col-3">
                                <input type="checkbox" id="active" value="`+evaluations[i].id+`" checked>
                            </div>
                        `;
                    } else {
                        data += `
                            <div class="col-3">
                                <input type="checkbox" id="active" value="`+evaluations[i].id+`">
                            </div>
                        `;
                    }
                            
                    data += `
                        </div>
                    `;
                }
                return data;
            }

            return 'No Evaluation';
        }

        $('a.evaluation').on('click', function(){
            let id = $(this).attr('id');
            var url = "{{ url('/dashboard/manager/') }}"+"/"+id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                success: function (result) {
                    $('.modal .modal-header').html('');
                    $('.modal .modal-body').html('');
                    $('.modal .modal-header').html(`
                        Performance Evaluation form
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    `);
                    $('.modal .modal-body').html(
                        `
                        <div class="container-fluid">
                            <div class="row" id="evaluation-form">
                                <div class="col-12">
                                    <form method="POST" action="{{ url('/dashboard/manager/`+id+`/evaluation_results') }}">
                                    @csrf
                                    <div class="container-fluid text-default">
                                        <div class="row">
                                            <div class="col-6">
                                                Name: <strong>`+result.data.name+`</strong>
                                            </div>
                                            <div class="col-6">
                                                <p class="float-right"> Date: <strong>{{ date('F d, Y') }} </strong></p>
                                            </div>
                                            <div class="col-6">
                                                Employee ID: <strong> `+result.data.username+` </strong>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-3">
                                            <strong>FACTOR</strong> 
                                            </div>
                                            <div class="col-6">
                                                <strong>DESCRIPTION</strong> 
                                            </div>
                                            <div class="col-3">
                                                <strong>Evaluation</strong>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach(\App\Evaluation::all() as $eval)
                                        <div class="row">
                                            <div class="col-3">
                                                {{ $eval->factor }}
                                            </div>
                                            <div class="col-6">
                                                {{ $eval->description }} 
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control" style="font-size: 10px;" name="{{ $eval->factor }}" id="eval">
                                                    <option value="0">0 - Not Applicable</option>
                                                    <option value="1">1 - Unsatisfactory</option>
                                                    <option value="2">2 - Below Average</option>
                                                    <option value="3">3 - Average</option>
                                                    <option value="4">4 - Above Average</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        @endforeach
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-label-group">
                                                <textarea class="form-control noresize" name="qualities" maxlength="200" id="qualities" rows="3" placeholder="Best qualities demonstrated"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-label-group">
                                                    <textarea class="form-control noresize" name="improvements" maxlength="200" id="improvements" rows="3" placeholder="How improvements can be Made"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-label-group">
                                                    <textarea class="form-control noresize" name="comments" maxlength="200" id="comments" rows="3" placeholder="Comments"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row text-center">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary form-control text-white">
                                                    {{ __('Save & Print') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        `
                    );
                },
            });
        });

        $('#activate-all').on('click', function(){
            var url = "{{ url('/dashboard/manager/update/all') }}";
            var id = "{{ auth()->user()->id }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id : id,
                    val: 1
                },
                success: function (result) {
                    toastr.info('Activating Employees...');
                    setTimeout(() => {
                        location.reload();                        
                    }, 3000);
                    
                }
            });
        });
        $('#deactivate-all').on('click', function(){
            var url = "{{ url('/dashboard/manager/update/all') }}";
            var id = "{{ auth()->user()->id }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id : id,
                    val: 0
                },
                success: function (result) {
                    toastr.info('Deactivating Employees...');
                    setTimeout(() => {
                        location.reload();
                    }, 3000);

                }
            });
        });

        $('#search').on("keyup", function(e){
            var value = $(this).val().toLowerCase();
            var content = $('#accordianId').html();
            if(value == ''){
                $('#accordianId').html(content);
            } else {
                $('#accordianId .card').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            }
        });

        $('#transferBtn').on('click', function() {
            var count = 0; var items = Array();
            $('input[type="checkbox"].emp').each(function() {
                if($(this).is(':checked')){
                    count++;
                    items.push($(this).attr('id'));
                }
            });

            if(count <= 0) {
                toastr.error('NO employee selected!');
                return false;
            }
            
            var url = "{{ url('/dashboard/transfer') }}";
                $.ajax({
                url: url,
                type: 'POST',
                data: {
                    values: items,
                    manager: $('#transfer').val()
                },
                success: function (result) {
                    toastr.success('Employees transferred!!');
                },
                error: function (error) {

                }
            });
        });
    });
</script>