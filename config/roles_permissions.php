<?php

return [

    'create_users' => false,
    'truncate_tables' => true,

    'roles_structure' => [

        'super_admin' => [
            'role' => 'c,va,v,u,d',
            'city' => 'c,va,v,u,d,da,fa,f,r,ra',
            'region' => 'c,va,v,u,d,da,fa,f,r,ra',
            'location' => 'c,va,v,u,d,da,fa,f,r,ra',
            'user' => 'c,va,v,u',
          
        ],

        'admin' => [
            'role' => 'c,va,v,u,d',
            'city' => 'c,va,v,u,d,da,fa,f,r,ra',
            'region' => 'c,va,v,u,d,da,fa,f,r,ra',
            'location' => 'c,va,v,u,d,da,fa,f,r,ra',
            'user' => 'c,va,v,u',
           
        ],
         'manger' => [
            'city' => 'va,v',
            'region' => 'va,v',
            'location' => 'va,v',
            'user' => 'va,v',
        ],

        'editor' => [
            'city' => 'c,va,v',
            'region' => 'c,va,v',
        ],

    ],

    'permissions_map' => [
        'c'  => 'create',
        'va' => 'view_any',  
        'v'  => 'view',      
        'u'  => 'update',
        'd'  => 'delete',
        'da' => 'delete_any',
        'fa' => 'force_delete_any',
        'f'  => 'force_delete',
        'r'  => 'restore',
        'ra' => 'restore_any',
    ],
];
