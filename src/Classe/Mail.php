<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
  private $api_key = 'df3c1439cb29ccf712637af3d061ecf8';
  private $api_key_secret = 'f5d6f18a57e92f5ba5da5ee38167d925';

  public function send($to_email, $to_name, $subject, $content)
  {
    $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']); 
    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "anthony-andre@live.fr",
            'Name' => "MyGameBox"
          ],
          'To' => [
            [
              'Email' => $to_email,
              'Name' => $to_name
            ]
          ],
          'TemplateID' => 3707082,
          'TemplateLanguage' => true,
          'Subject' => $subject,
          'Variables' => [
            'content' => $content
          ]
        ]
      ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();
  }
}
