<?php

declare(strict_types=1);

use Marioquartz\MakingSessions\Event;
use Marioquartz\MakingSessions\Maker;
use Marioquartz\MakingSessions\Session;
use PHPUnit\Framework\TestCase;

class MakerTest extends TestCase
{
    public function testAll(): void
    {
        $json_raw = file_get_contents(__DIR__.'/events.json');
        $json = json_decode($json_raw, true);

        $maker = new Maker();
        foreach ($json as $item) {
            $event = new Event();
            $event
                ->setStart($item['start'])
                ->setDuration(60)
                ->setType($item['type']);
            $maker->add($event);
        }
        $sessions = $maker->getSessions();
        $output = [];
        /**  @var array<Session> $sessions */
        foreach ($sessions as $session) {
            $item = [
                'start' => $session->getStart(),
                'end' => $session->getEnd(),
                'duration' => $session->getDuration(),
                'type' => $session->getType(),
            ];
            foreach ($session->getEvents() as $event) {
                $item['events'][] = [
                    'start' => $event->getStart(),
                    'end' => $event->getEnd(),
                    'duration' => $event->getDuration(),
                    'type' => $event->getType(),
                ];
            }
            $output[] = $item;
        }
        $output = json_encode($output);
        $expected = file_get_contents(__DIR__.'/expected.json');
        $this->assertEquals($expected, $output);
    }
}
