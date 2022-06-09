<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    function GetUsers(){
        return User::all(['id', 'name', 'email']);
    }
    function GetUserById($id){
        return User::where('id', $id)->get(['id', 'name', 'email']);
    }
    function GetUsersById($id1,$id2){
        return User::where('id', '>=', $id1)->where('id', '<=' , $id2)->get(['id', 'name', 'email']);
    }
    function AddUser(Request $req){
        if($req->hasFile('photo')){
            $image = $req->file('photo');
            $reImage = time(). '.' . $image->getClientOriginalExtension();
            $dect = public_path('/imgs');
            $image->move($dect, $reImage);
            \Tinify\setKey("M6pP0Nt46xtxJh3ddQnJs2hHY70TykrD");
            $source = \Tinify\fromFile('imgs/'.$reImage);
            $resized = $source->resize(array(
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ));
            $resized->toFile('imgs/'.$reImage);

            $user = new User();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->avatar = $reImage;
            $user->save();
            
            return response()->json([
                'success' => $req,
                'user' => $user,
                'message' => "New user successfully registere"
            ]);

        }else{
            return false;
        }

    }
}
