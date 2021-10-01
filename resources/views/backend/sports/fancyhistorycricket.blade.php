@extends('backend.layouts.appReport')

@section('title', app_name())

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
        <h2 class="d-inline-block">Fancy History</h2>
      </div>
      <a href="{{ route('admin.fancy_history.cricket')}}" class="btn btn-primary" style="margin: 5px;">Cricket</a>
      <a href="{{ route('admin.fancy_history.soccer')}}" style="margin: 5px;" class="btn ">Soccer</a>      
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <table id="clientListTable" class="table table-striped table-bordered dataTable no-footer" style="width:100%" role="grid" aria-describedby="clientListTable_info">
            <thead>
              <tr>
                <th style="width: 80%;">Match Name</th>
                <th>Fancy</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sports as $key=>$match)
              <tr role="row" class="even">
                  
                <td class="notLink">
                  <a style="background: none;color:#007bff;" href="javascript:void(0);">{{$match->match_name}} {{$match->match_date_time}}</a>
                </td>
                <td>
                  <a href="{{ route('admin.manage_history.single',$match->match_id) }}"> Fancy History</a>
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
//            buttons: [
//                {
//                    extend: 'pdfHtml5',
//                    title: 'Client List Report',
//                    exportOptions: {
//                        columns: "thead th:not(.noExport)"
//                    }
//                },
//                {
//                    extend: 'excel',
//                    title: 'Client List Report',
//                    exportOptions: {
//                        columns: "thead th:not(.noExport)"
//                    }
//                }
//            ]
      });
  } );


</script>

@endpush
