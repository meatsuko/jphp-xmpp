<?php

namespace meatsuko\xmjphp\stream;

use php\io\MiscStream;
use php\net\Socket;
use php\util\Regex;

class XMLStream
{
    protected $_streamInput;
    protected $_streamOutput;


    function __construct(Socket $socket)
    {
        $this->_streamInput = $socket->getInput();
        $this->_streamOutput =  $socket->getOutput();
        
    }

    public function write($content)
    {
        $this->_streamOutput->write($content);
        $this->_streamOutput->flush();
    }

    protected $_chunk;
    private function _prepareChunk()
    {
        $data = $this->_streamInput->read(1024);

        if(($data != -1) && ($data != "")) $this->_chunk .= $data;

        return true;
    }

    protected function _handleChunk()
    {
        #1 <stream:stream ([^*>]+)?\>
        #2 <([\w:]+)(\s[^*>]+)?\>([^*]+)?</\1>
        #3 <[^>]+/> - <success xmlns='urn:ietf:params:xml:ns:xmpp-sasl'/>

        $expressions = [
            'stream' => '<stream:stream ([^*>]+)?\>',
            'group' => '<([\w:]+)(\s[^*>]+)?\>([^*]+)?</\1>',
            'single' => '<[^>]+/>'
        ];
        
        
        foreach($expressions as $type => $expression)
        {
            $matches = Regex::of($expression, 'gm')->with($this->_chunk);
            $capture = $matches->first()[0];


            if($capture)
            {   
                $this->_chunk = substr($this->_chunk, $matches->start() + strlen($capture));
                
                var_dump($capture);
                return $capture .= ($type == "stream") ? "</stream:stream>" : "";
            }

            continue;
        }

        return false;
    }

    public function getNode()
    {
        while ($this->_prepareChunk())
        {
            if(($node = $this->_handleChunk())) return $node;
        }

        return false;
    }



}