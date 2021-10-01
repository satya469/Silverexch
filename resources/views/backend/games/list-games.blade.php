@extends('backend.layouts.appReport')

@section('title', app_name() . ' | Client List')

@section('content')
<div class="row">
  <div class="col-md-12 main-container">
    <div class="listing-grid">
      <div class="detail-row">
        <h2 class="d-inline-block">Main Market</h2>
        <div class="float-right m-b-10">
          <p class="text-right">
              <a  href="{{ route('admin.add-game') }}" class="btn btn-diamond">Add Sport</a>
          </p>
        </div>
      </div>
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <table id="clientListTable" class="table table-striped table-bordered dataTable no-footer" style="width:100%;" role="grid" aria-describedby="clientListTable_info">
            <thead>
              <tr role="row">
                <th>Sr.No.</th>
                <th>Sport Name</th>
                <th>Status</th>
                <th class="noExport" style="width:315px;">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($games as $index =>$game)
                <tr>
                    <td>{{$index+1}}</td>
                    <td><a style="background: none;color:#007bff;" href="{{ route('admin.listSports',$game->id)}}" >{{$game->name}}</a></td>
                    <td>
                    <a style="background: none;color:#007bff;" href="javascript:void();" id="status">{{ ($game->status == 1)? 'Active' : 'InActive' }}</a>
                    </td>
                    <td class="actions text-left noExport">
                      @if($game->name != 'CASINO')
                      <a href="{{ route('admin.addSports',$game->id)}}" >Add Match</a>
                      @endif
                      <a href="javascript:void(0);" onclick="changeStatus({{$game->id}},this);" >Change Status</a>
                      <a href="{{ route('admin.listSports',$game->id)}}" >Setting</a>
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
                    extend: 'csv',
                    title: 'game List',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
      });
      $('.buttons-csv').addClass('btn btn-success buttons-excel');
      $('.buttons-csv').css('margin-bottom','10px');
  } );
  
  function changeStatus(id,obj){
    if(confirm("Are You Sure Change Status")){
      $.ajax({
        url: "{{ route('admin.game.status')}}",
//        dataType: 'json',
        type: "post",
        data: {
            'id':id,
            '_token': "{{ csrf_token() }}",
        },
        beforeSend: function(){
    //        showLoading();
        },
        complete:function(){
    //        hideLoading();
        },
        success: function(response){
          jQuery.noConflict();
          if(response == 1){
            $(obj).closest('tr').find('#status').text('Active');
          }else{
             $(obj).closest('tr').find('#status').text('inActive');
          }
        },
      });
    }
  }
</script>

@endpush
