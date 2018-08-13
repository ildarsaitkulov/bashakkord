<?php

return [

    '/artist/find/<1>'      => '/Artist//Find(letter=<1>)',
    '/artist/admin/findAlph/<1>'=> '/Artist/Admin/FindAlph(letter=<1>)',
    '/artists'              => '/Artist///',
    '/artists/<1>'          => '/Artist//One(id=<1>)',

    '/songs'                => '/Song///',
    '/songs/famous'         => '/Song//Famous/',
    '/songs/admin/find/<1>'=> '/Song/Admin/Find(letter=<1>)',
    '/songs/<1>'            => '/Song//One(id=<1>)',


    '/about'                => '/Service//About',
    '/chords'               => '/Service//Chords',
    '/admin'                => '/Admin///',
    '/order'                => '/Service//Order/',
    '/add'                  => '/Service//Add/',

    '/news'                 => '/News///',
    '/news/topics'          => '/News//TopicsAll',
    '/news/topics/<1>'      => '/News//TopicOne(id=<1>)',
    '/news/<1>'             => '/News//One(id=<1>)',

    '/admin/<1>/<2>/<3>'    => '/Admin//Module(module=<1>,controller=<2>,action=<3>)',
    '/admin/<1>/<2>'        => '/Admin//Module(module=<1>,action=<2>)',
    '/admin/<1>'            => '/Admin//Module(module=<1>)',
];