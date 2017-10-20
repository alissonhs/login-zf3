<?php

namespace Login\Model;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Http\Client;
use Zend\Json\Json;

/**
 * Description of LoginAdapter
 *
 * @author Adriano Barbosa
 */
class LoginAdapter implements AdapterInterface {

    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate() {
        $client = new Client("http://www.paraisomodabebe.local/helpMeTi/autentica-fora/autenticar/");
        $client->setParameterGet([
            'usuario' => $this->username,
            'senha' => $this->password,
            'appkey' => "8c13f9ed1f13284ac55211156d0ab935",
        ]);
        $send = $client->send();
        if ($send->isSuccess()) {
            $resposta = Json::decode($send->getContent());
            if ($resposta->status == "allow") {
                return new Result(Result::SUCCESS, $resposta->usuario);
            }
        }
        return new Result(Result::FAILURE_UNCATEGORIZED, [],["Credenciais inválidas!"]);
    }

}
