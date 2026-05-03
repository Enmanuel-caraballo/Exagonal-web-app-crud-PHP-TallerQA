<?php

namespace Events;

abstract class DomainEvent
{
    private $eventName;
    private $ocurredOn;

    public function __construct($eventName){
        $this->eventName = $eventName;
        $this->ocurredOn = date('Y-m-d H:i:s');
    }

    public function eventName() { return $this->eventName;}
    public function ocurredOn(){ return $this->ocurredOn;}
    abstract  public function payload();
}