<?php

namespace kosogroup\xmjphp\server;

use meatsuko\xmjphp\dto\join\BootstrappDTO;
use meatsuko\xmjphp\XMPPBootstrapper;

class Main
{
    //application
    public static function Main($arguments)
    {
        $boootstrapp = (new BootstrappDTO(5222))
            ->setHandler(new XMPPServerHandler);
        new XMPPBootstrapper($boootstrapp);
    }
}   