<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'app-root', '_controller' => 'App\\Controller\\RootController::index'], null, null, null, false, false, null]],
        '/auth' => [[['_route' => 'app_auth', '_controller' => 'App\\Controller\\auth\\AuthController::index'], null, null, null, false, false, null]],
        '/chatbot' => [[['_route' => 'app_chatbot', '_controller' => 'App\\Controller\\chatbot\\ChatbotController::index'], null, null, null, false, false, null]],
        '/create/job' => [[['_route' => 'app_create_job', '_controller' => 'App\\Controller\\create_job\\CreateJobController::index'], null, null, null, false, false, null]],
        '/events' => [[['_route' => 'app_events', '_controller' => 'App\\Controller\\events\\EventsController::index'], null, null, null, false, false, null]],
        '/explore' => [[['_route' => 'app_explore', '_controller' => 'App\\Controller\\explore\\ExploreController::index'], null, null, null, false, false, null]],
        '/group' => [[['_route' => 'app_group', '_controller' => 'App\\Controller\\group\\GroupController::index'], null, null, null, false, false, null]],
        '/job/applications' => [[['_route' => 'app_job_applications', '_controller' => 'App\\Controller\\jobapplications\\JobApplicationsController::index'], null, null, null, false, false, null]],
        '/job/feed' => [[['_route' => 'app_job_feed', '_controller' => 'App\\Controller\\jobfeed\\JobFeedController::index'], null, null, null, false, false, null]],
        '/messagerie' => [[['_route' => 'app_messagerie', '_controller' => 'App\\Controller\\messagerie\\MessagerieController::index'], null, null, null, false, false, null]],
        '/organizer' => [[['_route' => 'app_organizer', '_controller' => 'App\\Controller\\organizer\\OrganizerController::index'], null, null, null, false, false, null]],
        '/profile' => [[['_route' => 'app_profile', '_controller' => 'App\\Controller\\profile\\ProfileController::index'], null, null, null, false, false, null]],
        '/social' => [[['_route' => 'app_social', '_controller' => 'App\\Controller\\social\\SocialController::index'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
