<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Channel;
use Illuminate\Support\Facades\Auth;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $channel=0;
        $users = User::where('id','<>',Auth::user()->id)->get();
        // dd(Auth::user()->id);
        return view('home',compact('users','channel'));
    }

    public function createChannel(Request $request)
    {
        $channel = 0;
        $first_id = $request->input('first_id');
        $sec_id = $request->input('sec_id');
        $first_email = $request->input('first_email');
        $sec_email = $request->input('sec_email');
        $IDs = $first_id.'--'.$sec_id;
        $result1 = Channel::where('user1_id',$first_id)->where('user2_id',$sec_id)->get();
        $result2 = Channel::where('user2_id',$first_id)->where('user1_id',$sec_id)->get();
        // dd($result1.''.$result2);
        $users = User::where('id','<>',Auth::user()->id)->get();
        if($result1->isEmpty() && $result2->isEmpty()){
            $sid    = "AC00c454dc839c77f91ab5b7c77ab8b7f4";
            $token  = "8f775641886be9343e928ee05e42563d";
            $twilio = new Client($sid, $token);
            // Fetch channel or create a new one if it doesn't exist

            $channel = $twilio->chat->v2->services("ISc4e202cd257a4b7da27ee307474c4fd7")
                    ->channels
                    ->create([
                            'uniqueName' => $IDs,
                            'type' => 'private',
            ]);
            $channelObj = new Channel;
            $channelObj->id = $channel->sid;
            $channelObj->user1_id = $first_id;
            $channelObj->user2_id = $sec_id;
            $channelObj->save();
            // dd($channel);
            $member1 = $twilio->chat->v2->services("ISc4e202cd257a4b7da27ee307474c4fd7")
                        ->channels($IDs)
                        ->members
                        ->create($first_email);
            $member2 = $twilio->chat->v2->services("ISc4e202cd257a4b7da27ee307474c4fd7")
                        ->channels($IDs)
                        ->members
                        ->create($sec_email);

            return view('home',compact('users','channel','member1','member2'));
        }
        return view('home',compact('users','channel'));
    }
}
