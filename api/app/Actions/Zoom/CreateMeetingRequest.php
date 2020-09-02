<?php


namespace App\Actions\Zoom;


final class CreateMeetingRequest
{
    private $topic;
    private $startTime;
    private $agenda;

    public function __construct(string $topic, $startTime, string $agenda)
    {
        $this->topic = $topic;
        $this->startTime = $startTime;
        $this->agenda = $agenda;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getAgenda()
    {
        return $this->agenda;
    }
}
