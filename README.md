# MakingSessions
This library has one goal: **organizing list of events in sessions**. You can add "events" with a start and end or, a duration. This library is made for separating the events for types of events.

The origin of this library is sort the actions when I work, each project is a different type of event. With this library now I can see how much time work in each project.

# Using the library

You start initialising the _Maker_ class and adding the events:

```php
use Marioquartz\MakingSessions\Maker;
use Marioquartz\MakingSessions\Event;

$maker=new Maker();
foreach ($list as $item) {
    $event=new Event();
    $event
        ->setStart($start) //start can be a timestamp or a DateInmutable
        ->setDuration(60) // you can set the duration or use setEnd()
        ->setType("example");
    $maker->add($event);
}
```

Generate the list of sessions with their events is easy:

```php
$sessions=$maker->getSessions();
```

Sessions now have a list of sessions, that can be iterated:

```php
foreach($sessions as $session) {
    echo $session->getStart(); // Start of the session returned as timestamp
    echo $session->getEnd(); //End as timestamp
    echo $session->getDuration() // Duration in seconds
    echo $session->getType(); // Type of the events inside
    foreach ($session->getEvents() as $event) {
        //events have the same functions: getStart(), getEnd(), getDuration() and getType()
    }
}
```

# Helping

This is my first real library. I don't have much experience, so of course this library have a big room for make better code or usefulness.
If you are a kind person, and you think have an idea or if you have a bug, im all ears.
