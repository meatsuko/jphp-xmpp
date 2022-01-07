<?php

namespace meatsuko\xmjphp;

use meatsuko\xmjphp\dto\join\BootstrappDTO;
use meatsuko\xmjphp\dto\join\ConnectionDTO;
use php\net\ServerSocket;

class XMPPBootstrapper
{
    function __construct(BootstrappDTO $bootstrapp)
    {
        $serverSocket = new ServerSocket(5222);
        
        while(true)
            (new XMPPConnection(
                (new ConnectionDTO())
                    ->impl_join($bootstrapp)
                    ->setSocket($serverSocket->accept())
                )
            );
    }
}
