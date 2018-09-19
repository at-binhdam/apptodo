<?php

return [
    'driver_default' => 'sqlite',
    
    'connections' => [
        'sqlite' => [
            'path' => ROOT . DS . 'databases' . DS . 'data.db'
        ]
    ],

    'migration' => [
        'tables' => [
            'tasks' => "
                CREATE TABLE IF NOT EXISTS tasks (
                    id Integer NOT NULL PRIMARY KEY AUTOINCREMENT,
                    name Text NOT NULL,
                    start_date Date NOT NULL,
                    end_date Date NOT NULL,
                    status Integer NOT NULL DEFAULT 0 
                );
                CREATE INDEX index_start_date ON tasks( start_date );
                CREATE INDEX index_end_date ON tasks( end_date );
            "
        ]
    ]
];