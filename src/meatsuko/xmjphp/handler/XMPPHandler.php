<?php

namespace meatsuko\xmjphp\handler;

use meatsuko\xmjphp\stream\XMLStream;
use php\xml\DomElement;

abstract class XMPPHandler
{
    public abstract function handle(DomElement $document, XMLStream $stream);
}   