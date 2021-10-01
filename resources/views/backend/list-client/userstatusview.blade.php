  <div class="m-t-20">
    <div class="col-md-12">
      <div class="float-right user-status">
        <p class="text-success" id="user-active-diff-s" style="display: none">Active</p>
        <p class="text-danger" id="user-active-diff-f" style="display: none">Inactive</p>
      </div>
    </div>
  </div>
            
  <ul class="status col-md-12 text-center m-t-20">
    <div class="row">
      <li class="col-md-6">
        <h4>User Active</h4>
        <label class="switch activeuser">
          <?php
          $active = '';
          if($depositeUser->active == '1'){
            $active = 'checked="checked"';
          }
          ?>  
          <input name="useractive" onchange="checkUserActive(this);" <?= $active ?> value="{{$depositeUser->active}}" id="status-user-active-s" type="checkbox">
          <div id="s_usr" class="slider">
            
              <span  class="on">On</span>
              <span  class="off">Off</span>
           
          </div>
        </label>
      </li>
      <li class="col-md-6">
        <h4>Bet Active</h4>
        <label class="switch betActive">
            <?php
          $betactive = '';
          if($depositeUser->betActive == '1'){
            $betactive = 'checked="checked"';
          }
          ?>  
          <input name="useractive" onchange="checkUserBetActive(this);" <?= $betactive ?> value="{{$depositeUser->betActive}}" id="status-bet-active-s" type="checkbox">
          <div id="s_bet" class="slider">
            
              <span  class="on">On</span>
              <span class="off">Off</span>
            
          </div>
        </label>
      </li>
    </div>
  </ul>
          
  <div class="modal-body m-t-20">
    <form action="" id="StatusForm" method="post" autocomplete="off" onsubmit="return false">
      <div class="container-fluid">
        <input name="useractive" id="status-bet-active" value="{{$depositeUser->betActive}}" type="hidden">
        <input name="useractive" id="status-user-active" value="{{$depositeUser->active}}" type="hidden">
        <div class="row">
          <div class="col-md-4">
            <label>Master Password</label>
          </div>
          <div class="col-md-8">
            <input type="Password" name="" id="m_pwd" required="">
          </div>
        </div>
      </div>
    </form>
  </div>