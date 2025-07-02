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
// Images Fetch
$router->routeCreate(
    "/api/images",
    ["ImagesController", "FetchAllImages"],
    "GET",
    false
);
$router->routeCreate(
    "/api/images/add",
    ["ImagesController", "AddImage"],
    "POST",
    true
);
$router->routeCreateRegex(
    '~^/api/images/([a-zA-Z0-9_-]+)$~',
    "fetchimage",
    ["ImagesController", "FetchImage"],
    "GET",
    true
);
$router->routeCreate(
    "/api/images/modify",
    ["ImagesController", "ModifyImage"],
    "POST",
    true
);
$router->routeCreateRegex(
    '~^/api/images/delete/([a-zA-Z0-9_-]+)$~',
    "deleteImage",
    ["ImagesController", "DeleteImage"],
    "GET",
    true
);
?>
