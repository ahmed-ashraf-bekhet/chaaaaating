<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;

class TokenController extends Controller
{

    public function generate(Request $request)
    {
        $user = $request->input("identity");
        $token = new AccessToken('AC00c454dc839c77f91ab5b7c77ab8b7f4','SK89a378b3240ea8805b111d22ef1124d2'
        ,'mMH4gKIXVNvsMjZquy8W1HLkIAA7k23H',3600,"asttt");

        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid('ISc4e202cd257a4b7da27ee307474c4fd7');
        $token->addGrant($chatGrant);

        $response = array(
            'identity' => "asttt",
            'token' => $token->toJWT(),
        );
        return response()->json($response);
    }

}
