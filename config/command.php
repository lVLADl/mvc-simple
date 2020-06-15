<?php
return [
    'commands' => [
        new \App\System\Command\ExampleCommand(),
        new \App\System\Command\Database\Migration(),
        new \App\System\Command\TestCommand(),
    ]
];
