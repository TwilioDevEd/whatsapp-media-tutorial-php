<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;

const GOOD_BOY_URL = "https://images.unsplash.com/photo-1518717758536-85ae29035b6d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80";

class WhatsappController extends Controller
{

    public function webhook(Request $request) {

        // Get number of images in the request
        $numMedia = (int) $request->input("NumMedia");

        Log::debug("Media files received: {$numMedia}");

        $response = new MessagingResponse();
        if ($numMedia === 0) {
            $message = $response->message("Send us an image!");
        } else {
            $message = $response->message("Thanks for the image! Here's one for you!");
            $message->media(GOOD_BOY_URL);
        }

        return $response;
    }

}
