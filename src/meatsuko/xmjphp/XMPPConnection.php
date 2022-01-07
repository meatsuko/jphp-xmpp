<?php
namespace meatsuko\xmjphp;

use meatsuko\xmjphp\dto\join\ConnectionDTO;
use meatsuko\xmjphp\stream\XMLStream;

use php\lang\Thread;
use php\xml\XmlProcessor;

class XMPPConnection
{
    private $_socket;
    private $_connection;

    private $_stream = null;

    function __construct(ConnectionDTO $connection)
    {
        $this->_connection = $connection;
        $this->_socket = $connection->getSocket();

        $this->_socket->setTcpNoDelay(true);

        $this->_stream = new XMLStream($this->_socket);

        (new Thread(function()
        {
            $xmlProcessor = new XmlProcessor;

            while (($node = $this->_stream->getNode()) != false)
            {
                $xmlDocument = $xmlProcessor->parse($node)->getDocumentElement();
    
                $this->_connection->getHandler()->handle($xmlDocument, $this->_stream);
            }
        }))->start();
    }


}