<?php

echo "What do you want?\n";

$command = trim(fgets(STDIN));

$commands = [
    'start' => [
        'description' => 'starts the work',
        'runs' => 'start_work'
    ],
    'stop' => [
        'description' => 'stops the work',
        'runs' => 'stop_work'
    ],
    'stats' => [
        'description' => 'show the stats',
        'runs' => 'stats'
    ],
    'clear' => [
        'description' => 'clears the current work',
        'runs' => 'clear'
    ]
];

if (empty($commands[$command])) {
    println("Unsupported Command");
    show_available_commands();
    exit();
}

require_once 'StopWatch.php';
require_once 'Storage.php';

$stopwatch = new StopWatch(new Storage("stopwatch.txt"));

$commands[$command]['runs']();



function start_work()
{
    global $stopwatch;
    if (false ===($started = $stopwatch->start())) {
        println("You have already started");
        exit();
    }
}

function stop_work()
{
    global $stopwatch;
    if (-1 === ($result = $stopwatch->stop())) {
        println("You haven't started yet");
        exit;
    }
    if (-2 ===$result){
        println("You already stop the time");
        exit;
    }
}

function stats()
{
    global $stopwatch;
    if (-1 === ($seconds = $stopwatch->show())) {
        println("You haven't started yet");
        exit;
    }

    println("You worked for : {$seconds} seconds");
}

function clear()
{
    global $stopwatch;
    $stopwatch->reset();
}


function println($s)
{
    echo "{$s}\n";
}

function show_available_commands()
{
    global $commands;
    foreach ($commands as $commandName => $value) {
        println($commandName . ": " . $value['description']);
    }
}
