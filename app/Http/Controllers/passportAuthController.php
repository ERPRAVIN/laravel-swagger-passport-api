<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class passportAuthController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Integration Swagger in Laravel with Passport Auth Documentation",
     *      description="Implementation of Swagger with in Laravel",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     * )
     * @OA\Post(
     *  path="/api/register",
     *   tags={"Regiser"},
     *   summary="Register",
     *     security={{"Bearer":{}}},
     *   operationId="register",
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *        @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *)
     */
    public function registerUserExample(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $access_token_example = $user->createToken('authToken')->accessToken;
        //return the access token we generated in the above step
        return response()->json(['token'=>$access_token_example],200);
    }

    /**
      * @OA\Post(
     *  path="/api/login",
     *   tags={"login"},
     *   summary="login",
     *   operationId="login",
     *
     * 
     * 
     * 
     *     @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *        @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *)
     */
    public function loginUserExample(Request $request){
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        // if(
            auth()->attempt($login_credentials);
            // ){
            //generate the token for the user
            $user_login_token= auth()->user()->createToken('authToken')->accessToken;
            //now return this token on success login attempt
            return response()->json(['success' => 'LoggedIn','token' => $user_login_token], 200);
        // }
        // else{
            //wrong login credentials, return, user not authorised to our system, return error code 401
            // return response()->json(['error' => 'UnAuthorised Access'], 401);
        // }
    }

    /**
     * This method returns authenticated user details
     */
    public function authenticatedUserDetails(){
        //returns details
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }
}
