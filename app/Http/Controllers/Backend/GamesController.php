<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Games;
use Auth;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth\User;
class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $games = Games::all();
      return view('backend.games.list-games', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('backend.games.add-game');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.add-game',$uuid)->withFlashSuccess('Master Password Wrong');
      }
      $model = new Games();
      $model->name = $request->input('name');
      $model->status = $request->input('status');
      $model->save();
      
      return redirect()->route('admin.list-game')->withFlashSuccess('Sport added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $model = Games::findOrFail($id);
      return view('backend.games.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $requestData = $request->all();
      $userId = Auth::user()->id;
      $m_pwd =  $requestData['m_pwd'];
      $user = User::find($userId);
      if (!Hash::check($m_pwd, $user->password)) {
        return redirect()->route('admin.add-game',$uuid)->withFlashSuccess('Master Password Wrong');
      }
      $model = Games::findOrFail($id);
      $model->name = $request->input('name');
      $model->status = $request->input('status');
      $model->save();
      
      return redirect()->route('admin.list-game')->withFlashSuccess('Sport updated successfully');
    }
    
    public function status(Request $request){
      $id = $request->input('id');
      $model = Games::findOrFail($id);
      if($model->status == 1){
        $model->status = 0;
      }else{
        $model->status = 1;
      }
      $model->save();
      return $model->status;
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
