<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Thing;
use Auth;
use Validator;
use App\Rules\AllowedApp;

class ThingController extends Controller 
{

    public $successStatus = 200;
    public $unauthorizedStatus = 401;

    public function createThing(Request $request) {

        $input = $request->all();

        $validator = Validator::make($input, 
            [ 
                'title' => 'required|string',
                'description' => 'required|string',
                'app_name' => ['required', 'string', new AllowedApp],
            ]); 

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], $this->unauthorizedStatus);
        } 
        
        $thing = Thing::create([
            'user_id' => Auth::user()->id,
            'title' => $input['title'],
            'description' => $input['description'],
        ]);

        return response()->json(['success'=>$thing], $this->successStatus); 
    }

    public function getThing(Request $request) {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'id' => 'required',
        ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], $this->unauthorizedStatus);
        } 

        $thing = Thing::forCurrentUser()->find($input['id']);

        if (is_null($thing)) {
            return response()->json(['error'=>'Unauthorized to view this thing, or it may not exist.'], $this->unauthorizedStatus);
        }
        
        return response()->json(['thing' => $thing], $this->successStatus); 
    }

    public function getUserThings() {
        $things = Thing::forCurrentUser();

        if (is_null($things)) {
            return response()->json(['error'=>'Unauthorized to view these things, or they may not exist.'], $this->unauthorizedStatus);
        }
        
        return response()->json(['things' => $things], $this->successStatus); 
    }

    public function updateThing(Request $request) {
        $input = $request->all();

        $validator = Validator::make($input, 
            [ 
                'id' => 'required',
                'app_name' => ['required', 'string', new AllowedApp],
            ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], $this->unauthorizedStatus);
        }  

        $thing = Thing::forCurrentUser()->find($input['id']);

        if (is_null($thing)) {
            return response()->json(['error'=>'Unauthorized to update this thing, or it may not exist.'], $this->unauthorizedStatus);
        }

        $thing->update($input);
        
        return response()->json(['thing' => $thing], $this->successStatus); 
    }

    public function deleteThing(Request $request) {
        $input = $request->all();

        $validator = Validator::make($input, 
            [ 
                'id' => 'required',
                'app_name' => ['required', 'string', new AllowedApp],
            ]); 

        $thing = Thing::forCurrentUser()->find($input['id']);

        if (is_null($thing)) {
            return response()->json(['error'=>'Unauthorized to delete this thing, or it may not exist.'], $this->unauthorizedStatus);
        }
        
        $thing->delete();
        
        return response()->json(['success' => 'Thing deleted.'], $this->successStatus); 
    }

} 