@extends('backend.layouts.appReport')

@section('title', app_name())

@section('content')


<div class="row">
  <div class="col-md-12 main-container">
    <div>
      <div class="add-account">
        <h2 class="m-b-20">Add Match</h2>
        <form id="account_createForm" method="post" action="{{route('admin.sports.store')}}">
          
         <div class="row">
            <div class="col-md-6 personal-detail">
              <!--<h4 class="m-b-20 col-md-12">Match Detail</h4>-->
                  <div class="form-group">
                    <label for="match_name">Match Name:</label>
                    {{ html()->text('match_name')
                                    ->class('form-control')
                                    ->placeholder('Match Name')
                                    ->required()
                                    ->autofocus() }}
                    <span id="match_name-error" class="error" style="display: none">Match Name already taken</span>
                    <span id="match_name-required" class="error"></span>
                  </div>
                  @if($gameModel->name != 'CASINO')
                  <div class="form-group">
                    <label for="match_date_time">Match Date Time:</label>
                    {{ html()->text('match_date_time')
                                    ->class('form-control')
                                    ->placeholder('Match Date Time')
                                    ->required() }}
                    <span id="match_date_time-error" class="error"></span>
                  </div>
                  <div class="form-group">
                    <label for="match_id">Match ID:</label>
                    {{ html()->text('match_id')
                                    ->class('form-control')
                                    ->placeholder('Match ID')
                                    ->required() }}
                    <span id="match_id-error" class="error"></span>
                  </div>
                  @endif
            </div>
            <div class="col-md-6 account-detail">
              @if($gameModel->name != 'CASINO')  
              <!--<h4 class="m-b-20 col-md-12">Tv / Scoreboard Url Details</h4>-->
<!--              <div class="form-group">
                <label for="tv_url">TV Url:</label>
                {{ html()->text('tv_url')
                                ->class('form-control')
                                ->placeholder('Tv Url') }}
                <span id="tv_url-error" class="error"></span>
              </div>-->

              <div class="form-group" id="exposer-limit">
                <label for="sb_url">Scoreboard Url:</label>
                {{ html()->text('sb_url')
                                ->class('form-control')
                                ->placeholder('Scoreboard Url') }}
               <span id="sb_url-error" class="error"></span>
              </div>
              <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label for="tv_status">TV:</label>
                {{ html()->checkbox('tv_status') }}
                <span id="tv_status-error" class="error"></span>
              </div>
                  </div>
              <div class="col-md-6">
                <div class="form-group" id="exposer-limit">
                  <label for="bookmaker_status">bookmaker:</label>
                  {{ html()->checkbox('bookmaker_status') }}
                 <span id="bookmaker_status-error" class="error"></span>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group" id="exposer-limit">
                  <label for="fancy_status">fancy:</label>
                  {{ html()->checkbox('fancy_status') }}
                 <span id="fancy_status-error" class="error"></span>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group" id="exposer-limit">
                  <label for="inplay_status">inplay:</label>
                  {{ html()->checkbox('inplay_status') }}
                 <span id="inplay_status-error" class="error"></span>
                </div>
              </div>
              </div>
              @endif
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
                <input type="hidden" name="gameID" value="{{$id}}">
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



