<?php
return [
    'commands' => [
        new \App\System\Command\ExampleCommand(), # app:example-command
        new \App\System\Command\Database\Migration(), # app:migrate
        new \App\System\Command\TestCommand(), # app:check TODO: remove
    ]
];
