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

        $mockRetrieve = $this->createMock(CurlFileRetrieveService::class);
        $mockRetrieve->expects($this->once())
                     ->method("requestContent" )
                     ->with('http://media.com/file')
                     ->willReturn('text content');

        $mockStorage = $this->createMock(FileSystemStorageService::class);
        $mockStorage->expects($this->once())
                    ->method("saveFile")
                    ->with('file.txt', 'text content')
                    ->willReturn(null);

        $request = new Request([
            'NumMedia' => '1',
            'MediaUrl0' => 'http://media.com/file',
            'MediaContentType0' => 'text/plain',
        ]);

        $controller = new WhatsappController($mockRetrieve, $mockStorage);

        $response = $controller->webhook($request);

        $this->assertTrue($response instanceof MessagingResponse);
    }
}
