@extends('backend.layouts.app')

@section('title', app_name() . ' | Add Sport')

@section('content')


<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="add-account">
        <h2 class="m-b-20">Add Sport</h2>
        <form id="account_createForm" method="post" action="{{route('admin.game.store')}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              <!--<h4 class="m-b-20 col-md-12">Sport Detail</h4>-->
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="username">Sport Name:</label>
                    {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder('Sport Name')
                                    ->required()
                                    ->autofocus() }}
                    <span id="name-error" class="error" style="display: none">Sport Name already taken</span>
                    <span id="name-required" class="error"></span>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="hidden" name="status" value="0"/>
                    <input type="checkbox" name="status" value="1"/>
                    <span id="phone-error" class="error"></span>
                  </div>
                </div>
                  
              </div>
            </div>
            
          </div>
          
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="form-group col-md-3 float-right">
                <label for="m_pwd">Master Password:</label>
                <input required="" maxlength="15" placeholder="Master Password" name="m_pwd" id="m_pwd" value="" type="password" class="form-control">
                <span id="m_pwd-error" class="error"></span>
              </div>
            </div>
          </div>
          <div class="row m-t-20">
            <div class="col-md-12">
              <div class="float-right">
                @csrf
                <input type="hidden" name="email" value="{{ rand(1111,9999)."@admin.com" }}">
                <input type="hidden" name="active" value="1">
                <input type="hidden" name="confirmed" value="1">
                <input type="hidden" name="permissions[]" value="view frontend">
                <button class="btn btn-submit" type="submit">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    
  </div>
</div>


@endsection


@push('after-scripts')
<script type="text/javascript">
  $(document).ready(function() {
   
      $('#clientListTable').DataTable( {
            "pageLength": 50,
            "order": [],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: 'excel',
                    title: 'Client List Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
      });
  } );


</script>

@endpush
