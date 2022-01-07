<?php

namespace meatsuko\xmjphp\dto\join;

use php\net\Socket;

class ConnectionDTO extends BootstrappDTO
{
    private $_socket;
    public function setSocket(Socket $socket)
    {
        $this->_socket = $socket;
        return $this;
    }
    public function getSocket() : Socket
    {
        return $this->_socket;
    }

    public function impl_join(BootstrappDTO $bootstrapp) : ConnectionDTO
    {
        $this->setPort($bootstrapp->getPort());
        $this->setHandler($bootstrapp->getHandler());

        return $this;
    }
}   