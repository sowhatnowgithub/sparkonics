<?php

namespace Sowhatnow;

class Env
{
    public const BASE_PATH = __DIR__;
    public const HOST_ADDRESS = "https://80b9-103-217-212-95.ngrok-free.app"; // For tesing http://localhost
    public const API_HOST = "0.0.0.0";
    public const API_PORT = "1978"; // why 1978? Mums Birthday
    public const API_BASE_URL = "https://80b9-103-217-212-95.ngrok-free.app"; // For testing http://localhost:1978
    public const API_IMAGES_PATH = __DIR__ . "/api/Models/Database/Images";
    // also the thrds.js for websocker connection
}
