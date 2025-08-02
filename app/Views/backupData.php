<?php
$zip = new ZipArchive();
$zipFileName = $url . "/app/Views/dbs.zip";

if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
    $src = $url . "/api/Models/Database";
    $files = scandir($src);
    foreach ($files as $file) {
        if ($file == "." || $file == "..") {
            continue;
        }
        $fullPath = $src . DIRECTORY_SEPARATOR . $file;
        if (is_file($fullPath)) {
            $zip->addFile($fullPath, "/api/Models/Database/$file");
        }
    }
    $src = $url . "/api/Models/Database/Images";
    $files = scandir($src);
    foreach ($files as $file) {
        if ($file == "." || $file == "..") {
            continue;
        }
        $fullPath = $src . DIRECTORY_SEPARATOR . $file;
        if (is_file($fullPath)) {
            $zip->addFile($fullPath, "/api/Models/Database/Images/$file");
        }
    }
    $zip->addFile(
        $url . "/app/Models/Database/members.db",
        "/app/Models/Database/members.db"
    );
    $zip->addFile(
        $url . "/app/Views/logs/user.log",
        "/app/Views/logs/user.log"
    );
    $zip->addFile(
        $url . "/app/Models/Database/Scheduler.db",
        "/app/Models/Database/Scheduler.db"
    );
    $zip->close();
    header("Content-Type: application/zip");
    header('Content-Disposition: attachment; filename="dbs.zip"');
    header("Content-Length: " . filesize($zipFileName));
    readfile($zipFileName);
    unlink($zipFileName);
} else {
    echo "Failed to send the zip file";
}
