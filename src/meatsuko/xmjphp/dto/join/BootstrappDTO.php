<?php

namespace meatsuko\xmjphp\dto\join;

use meatsuko\xmjphp\handler\XMPPHandler;

class BootstrappDTO
{
    private $_port;
    public function setPort($port)
    {
        $this->_port = $port;
        return $this;
    }
    public function getPort()
    {
        return $this->_port;
    }
    
    function __cosntruct($port = 5222)
    {

    }

    private $_handler;
    public function setHandler(XMPPHandler $handler)
    {
        $this->_handler = $handler;
        return $this;
    }
    public function getHandler() : XMPPHandler
    {
        return $this->_handler;
    }




}