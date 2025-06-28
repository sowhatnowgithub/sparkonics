<?php
$router->routeCreate(
    "/api/events", // uri
    ["EventsPageController", "FetchAllEvents"], // action controller
    "GET", // request method
    false // args exist or not
);
$router->routeCreate(
    "/api/events/add",
    ["EventsPageController", "AddEvent"],
    "POST",
    true
);
$router->routeCreate(
    "/api/events/modify",
    ["EventsPageController", "ModifyEvent"],
    "POST",
    true
);
$router->routeCreateRegex(
    '~^/api/events/delete/([a-zA-Z0-9_-]+)$~',
    "deleteEvent",
    ["EventsPageController", "DeleteEvent"],
    "GET",
    true
);
$router->routeCreateRegex(
    '~^/api/events/([a-zA-Z0-9_-]+)$~',
    "fetchEvent",
    ["EventsPageController", "FetchEvent"],
    "GET",
    true
);
// Routes fof Profs
$router->routeCreate(
    "/api/profs",
    ["ProfsPageController", "FetchAllProfs"],
    "GET",
    false
);
$router->routeCreate(
    "/api/profs/add",
    ["ProfsPageController", "AddProf"],
    "POST",
    true
);
$router->routeCreateRegex(
    '~^/api/profs/([a-zA-Z0-9_-]+)$~',
    "fetchProf",
    ["ProfsPageController", "FetchProf"],
    "GET",
    true
);
$router->routeCreate(
    "/api/profs/modify",
    ["ProfsPageController", "ModifyProf"],
    "POST",
    true
);
$router->routeCreateRegex(
    '~^/api/profs/delete/([a-zA-Z0-9_-]+)$~',
    "deleteProf",
    ["ProfsPageController", "DeleteProf"],
    "GET",
    true
);
?>
