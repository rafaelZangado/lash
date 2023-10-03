<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function enviarMensagem()
    {
       $token = 'EAAD6qPCiatcBO9ZBaCPZAGxSPKNSd5JuZCBvWkXidlHzKXFKBXYJvTs3o1rBpxKMPqqWNqWOuuyswtiATksvZCk978tOLMpR2cVNff50di6SXJJFmXciUKZCPXCx26pHHNF9j2hCfq15ppZCcAJwBHszZB4ZCAnlZB5fZAufDBu14PktpEBvoccYBb5gybCVIJGMAW317WnCPOWZBIZB0vCFSwoa';
       $url = 'https://graph.facebook.com/v17.0/136266532899856/messages';

        $msg = $this->msgretorno();


        $headers = [
            "Authorization: Bearer " . $token,
            "Content-Type: application/json",
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $msg);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        print_r($response);



    }

    public function msgretorno()
    {
        $phone = '5598987030735';
       // $phone = '559896185121';

        return '{
            "messaging_product": "whatsapp",
            "to": "'.$phone.'",
            "type": "template",
            "template": {
                "name": "hello_world",
                "language": {
                    "code": "en_US"
                }
            }
        }';
    }

    public function msgatendimento()
    {
        $phone = '5598987030735';
        $msg = 'Ola, voce tem um retorno para o dia 04/09';
        return '{
            "messaging_product": "whatsapp",
            "to": "'.$phone.'",
            "type": "text",
            "template": {
                "name": "hello_world",
                "language": {
                    "code": "en_US"
                }
            }
        }';
    }

    public function msgcuidado()
    {
        return 'essa é a lista de cuidados que voce tem que ter';
    }


    public function msg()
    {
       // Suas credenciais do Twilio
        $sid = "AC7e0d3fd15456cb06f3ed671fca201977";
        $token = "ebd965d2152363ec11d26291335934a9";
        $phone1 = '351915508463';
        //559896185121
        $phone2 = '559896185121';
        // Número de telefone para o qual você deseja enviar a mensagem

        $to = "whatsapp:+{$phone1}";

        // Número de telefone Twilio do remetente
        $from = "whatsapp:+14155238886";

        // Corpo da mensagem que você deseja enviar
        $body = "Rafael Andrade, estou enviando uma msg de teste. se tu recebeu me avisa.";

        // Inicialize o cliente Twilio
        $twilio = new Client($sid, $token);

        // Envie a mensagem
        $message = $twilio->messages->create(
            $to,
            [
                "from" => $from,
                "body" => $body,
            ]
        );

        // Imprima o SID da mensagem para verificar se foi enviada com sucesso
        echo "Mensagem enviada com sucesso, SID: " . $message->sid;
    }
}
