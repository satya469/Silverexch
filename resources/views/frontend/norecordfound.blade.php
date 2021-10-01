@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')



<div class="row" style="margin-left: 0px;margin-right: 0px;">
  @include('frontend.game-list.leftSide')
  <!----> 
  <div class="col-md-10 featured-box">
    <div>
      <!----> 
      <div class="pb-4 mt-4">
        
        <div class="tab-content">
          <div class="tab-pane active">
            <div class="coupon-card coupon-card-first">
              <div class="card-content mobile-scroll" >
                <table class="table coupon-table destopview">
                  <thead>
                    <tr>
                      <th style="width: 63%;">Game</th>
                      <th colspan="2">1</th>
                      <th colspan="2">X</th>
                      <th colspan="2">2</th>
                    </tr>
                  </thead>
                  <tbody>
                      
                 
                    <tr class="rows">
                    <td colspan="4">
                       No Record Found
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
                    <div class="mobileView mobileViewOdds " style="padding: 10px;">
                      <p class="alert alert-danger">No Record Found</p>
                    
                </div>    
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('frontend.game-list.gameBottom')
    </div>
  </div>
</div>

@endsection


