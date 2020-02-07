<?php

use \App\Services\CurlFileRetrieveService;
use \App\Services\FileSystemStorageService;
use \App\Http\Controllers\WhatsappController;
use Illuminate\Http\Request;
use Twilio\TwiML\MessagingResponse;


class WhatsappControllerTest extends TestCase
{
    /**
     * Test whatsapp webhook controller
     *
     * @return void
     */
    public function testWebhook()
    {
        $request = new Request([
            'NumMedia' => '1',
            'MediaUrl0' => 'http://media.com/file',
            'MediaContentType0' => 'text/plain',
        ]);

        $controller = new WhatsappController();

        $response = $controller->webhook($request);

        $this->assertTrue($response instanceof MessagingResponse);
    }
}
