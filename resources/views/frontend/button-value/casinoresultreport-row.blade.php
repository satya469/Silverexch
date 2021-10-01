<table id="table-data" class="table table-striped table-bordered datatable dataTable no-footer">
  <thead>
    <tr>
      <th width="30%">Round ID</th>
      <th>Winner</th>
    </tr>
  </thead>
  <tbody id="">
  @foreach($casinoModel as $key=>$data)
    <tr>
      <td width="30%">{{$data->roundID}}</td>
      <td>{{$data->result}}</td>
    </tr>
  @endforeach
  </tbody>
</table>

<script type="text/javascript">
  
  $(document).ready(function() {
      var table = $('#table-data').DataTable( {
            "pageLength": 50,
            "order": [],
            orderCellsTop: true,
            dom: 'Bfrtip',
            buttons: [
               
            ],
      });
      
      
  } );
</script>