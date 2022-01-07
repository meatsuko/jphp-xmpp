<?php

namespace kosogroup\xmjphp\server;

use meatsuko\xmjphp\handler\XMPPHandler;
use meatsuko\xmjphp\stream\XMLStream;

use php\xml\DomElement;

class XMPPServerHandler extends XMPPHandler
{
    private $auth = true;
    //Override
    public function handle(DomElement $document, XMLStream $stream)
    {
        switch($document->getNodeName())
        {
            case "stream:stream":
                $stream->write("<?xml version='1.0'?>");
                $stream->write("<stream:stream xmlns='jabber:client' xmlns:stream='http://etherx.jabber.org/streams' id='2689330648' from='jabber.ru' version='1.0' xml:lang='en'>");
                if($this->auth)
                {
                   


                
                    //to-do: features
                    $stream->write("<stream:features>
                    <compression xmlns='http://jabber.org/features/compress'>
                    <method>zlib</method>
                    </compression>
                    <mechanisms xmlns='urn:ietf:params:xml:ns:xmpp-sasl'>
                    <mechanism>PLAIN</mechanism>
                    </mechanisms>
                    <register xmlns='http://jabber.org/features/iq-register'/>
                    </stream:features>");
                }
                else
                {
                    $stream->write("<stream:features>
                    <bind xmlns='urn:ietf:params:xml:ns:xmpp-bind'/>
                    <session xmlns='urn:ietf:params:xml:ns:xmpp-session'/>
                    </stream:features>");                    
                }
                


                
                
                break;

            case "auth":
                //only dev...
                $stream->write("<success xmlns='urn:ietf:params:xml:ns:xmpp-sasl'/>");
                $this->auth = false;
                break;

            case "iq":
                $type = $document->getAttribute("type");
                $id = $document->getAttribute("id");

                $node = $document->getFirstChild();
                $nodeChild = $node->getFirstChild();
                switch($node->getNodeName())
                {
                    case "bind":
                        if($nodeChild->getNodeName() == "resource")
                        {
                            $stream->write("<iq id='{$id}' type='result'>
                            <bind xmlns='urn:ietf:params:xml:ns:xmpp-bind'>
                            <jid>meatsuko@localhost/legacy</jid>
                            </bind>
                            </iq>");
                        }
                        break;
                    
                    case "session":
                        $stream->write("<iq type='result' id='{$id}'>
                        <session xmlns='urn:ietf:params:xml:ns:xmpp-session'/>
                        </iq>");
                        break;
                    
                }

                break;
        }
    }
}   