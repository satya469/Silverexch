<table class="table">
  <thead>
      <tr>
          <th>User Name</th>
          <th>Action</th>
      </tr>
  </thead>
  <tbody>
      @foreach($UserData as $key=>$data)
      <?php
      if($data->roles->first()->name != 'user'){
        continue;
      }
      $checked = '';
      if(isset($userLockModel->extra)){
        $extra = explode(',', $userLockModel->extra);
        if(in_array($data->id, $extra)){
          $checked = 'checked="checked"';
        }
      }
      ?>
      <tr>
          <td>{{$data->first_name}}</td>
          <td><input {{$checked}} type="checkbox" data-user-id="{{$data->id}}" class="lockUSer" value="{{$data->id}}"></td>
      </tr>
      @endforeach
  </tbody>
</table>
