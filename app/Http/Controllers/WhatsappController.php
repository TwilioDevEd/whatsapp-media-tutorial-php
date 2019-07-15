<?php


namespace App\Http\Controllers;

use App\Services\FileRetrieveService;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Magyarjeti\MimeTypes\MimeTypeConverter;
use Twilio\TwiML\MessagingResponse;

const GOOD_BOY_URL = "https://images.unsplash.com/photo-1518717758536-85ae29035b6d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80";

class WhatsappController extends Controller
{

    /**
     * @var MimeTypeConverter
     */
    private $mimeTypeService;

    /**
     * @var FileRetrieveService
     */
    private $fileRetrieveService;

    /**
     * @var FileStorageService
     */
    private $fileStorageService;

    /**
     * Create a new controller instance.
     *
     * @param FileRetrieveService $fileRetrieveService
     * @param FileStorageService $fileStorageService
     */
    public function __construct(FileRetrieveService $fileRetrieveService,
                                FileStorageService $fileStorageService)
    {
        $this->mimeTypeService = new MimeTypeConverter();
        $this->fileRetrieveService = $fileRetrieveService;
        $this->fileStorageService = $fileStorageService;
    }

    public function webhook(Request $request) {

        // Get number of images in the request
        $numMedia = (int) $request->input("NumMedia");

        for($idx = 0; $idx < $numMedia; $idx++) {

            $mediaUrl = $request->input("MediaUrl{$idx}");
            $mimeType = $request->input("MediaContentType{$idx}");

            $fileContent = $this->fileRetrieveService->requestContent($mediaUrl);

            $fileExtension = $this->mimeTypeService->toExtension($mimeType);

            $pathParts = explode('/', parse_url($mediaUrl)['path']);

            $mediaSid = end($pathParts);

            $this->fileStorageService->saveFile("{$mediaSid}.{$fileExtension}", $fileContent);
        }

        Log::debug("Media files received: {$numMedia}");

        $response = new MessagingResponse();
        if ($numMedia === 0) {
            $message = $response->message("Send us an image!");
        } else {
            $message = $response->message("Thanks for the image(s).");
        }
        $message->media(GOOD_BOY_URL);

        return $response;
    }

}
