@extends('backend.layouts.appReport')

@section('title', app_name() . ' | Client List')

@section('content')

<style>
    .data-table table td a{
      background: none;
      color:#007bff;
    }
</style>
<div class="row">
  <div class="col-md-12 main-container">
    <div class="listing-grid">
      <div class="detail-row">
        <h2 class="d-inline-block">Match History</h2>
      </div>
        <div id="msg"></div>
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <table id="clientListTable" class="table table-striped table-bordered dataTable no-footer" style="width:100%" role="grid" aria-describedby="clientListTable_info">
            <thead>
              <tr>
                <th>Sr. No.</th>  
                <th >Sport Name</th>
                <th style="width: 45%;">Match Name</th>
                <th>Match id</th>
                <th>Open Date</th>
                <th>Winner</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                
              @foreach($sports as $key=>$match)
              <tr role="row" class="even">
                <td>{{$key+1}} </td>
                <td>{{$match->game_name}} </td> 
                <td class="notLink">
                  {{$match->match_name}}
                </td>
                <td>{{$match->match_id}}</td>
                <td>{{$match->match_date_time}}</td>
                <td><b>{{ $match->winner}}</b></td>
                <td>
                    <a href="javascript:void(0);" onclick="resultRollBack('{{ $match->id}}',this);">Result RollBack</a>
                </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
         </div>
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

function resultRollBack(id,obj){
  if(!confirm('Are you Sure RollBasck?')){
    return false;
  }
  $.ajax({
      url: "{{route('admin.sports.resultrollback')}}",
      type: "POST",
      dataType: 'json',
      data: {
          'id':id,
          '_token': "{{ csrf_token() }}",
      },
      beforeSend: function(){
            showLoading('clientListTable');
      },
      complete:function(){
            hideLoading('clientListTable');
      },
      success: function(response){
        if(response.status == true){
          $('#msg').html(response.message);
          $(obj).closest('tr').remove();
        }
      },
    });
}
</script>

@endpush
