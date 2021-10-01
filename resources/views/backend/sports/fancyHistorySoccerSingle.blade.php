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
      <div class="table-responsive data-table">
        <div id="clientListTable_wrapper" class="dataTables_wrapper no-footer">
          <!--<table style="width:80%;" class="table coupon-table table table-striped table-bordered m-t-10">-->
          <table class="table coupon-table table table-striped table-bordered m-t-10">
            <thead>
              <tr>
                <th class="text-center">Sr.No.</th>
                <th class="text-left ">Fancy Name</th>
                <th class="text-center">Result</th>
                <th class="text-center">Date Time</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>  
            <tbody>
              @foreach($fancyHistory as $key=>$data)
              
              <tr role="row" class="odd">
                <td class="text-center">{{ $key+1 }}</td>  
                <td class="text-left ">{{$data->fancyName}}</td>
                <td class="text-center">{{$data->result}}</td>
                <td class="text-center">{{$data->created_at}}</td>
                <td class="text-center"><div class="resultText"></div>   
                    <a href="javascript:void(0);" onclick="rollBackFancy('{{$data->id}}',this);">Result RollBack</a>
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
  
  function rollBackFancy(fancyID,obj){
    if(!confirm("Are You Sure RollBack Result ?")){
      return false;
    }
    
    $.ajax({
    url: "{{ route('admin.sports.resultrollbackSoccersession')}}",
    type: "post",
    dataType: 'json',
    data: {
        'fancyID':fancyID,
        '_token': "{{ csrf_token() }}",
    },
    beforeSend: function(){
//        showLoading();
    },
    complete:function(){
//        hideLoading();
    },
    success: function(response){
      if(response.status == true){
        $(obj).closest('tr').remove();
        alert("RollBack Successfully");
      }
    },
  });
  }
  
</script>

@endpush
