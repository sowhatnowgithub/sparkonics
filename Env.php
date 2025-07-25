<?php

namespace Sowhatnow;

class Env
{
    // NEver forget this never end any url or path with /, and also always start with /
    public const BASE_PATH = __DIR__;
    public const HOST_ADDRESS = "https://localhost"; // For tesing http://localhost
    public const API_HOST = "0.0.0.0";
    public const API_PORT = "1978"; // why 1978? Mums Birthday
    public const API_BASE_URL = "http://localhost:1978"; // For testing http://localhost:1978
    public const API_IMAGES_PATH = __DIR__ . "/api/Models/Database/Images";
    // also the thrds.js for websocker connection
    // also don't forget to check the public folder for api calls and images
    // And also don't forget scheduler needs absolute path
}
