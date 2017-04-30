<?php

return [
    'models' => [
        'user' => App\User::class,
        'role' => Nurmanhabib\ActorManager\Models\Role::class,
        'ability' => Nurmanhabib\ActorManager\Models\Ability::class,
    ],

    'pivot_tables' => [
        'user_role' => 'user_role',
        'permissions' => 'permissions',
    ]
];
