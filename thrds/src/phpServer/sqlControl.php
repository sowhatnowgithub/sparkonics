<?php

require "credentials.php";

$createThrd = 'create table thrd (
private_thrdid INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	public_thrdid TEXT not null,
	thrd_name TEXT not null,
	user_name TEXT not null,
	thrd_date TEXT not null

)';

$createMessage = 'CREATE TABLE message (
	public_id TEXT not null,
	message_user TEXT not null,
	message TEXT not null,
	message_date TEXT not null
)';

try {
    $db = new PDO("sqlite:message.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query($createThrd);
    $db->query($createMessage);
} catch (PDOException $e) {
    echo $e;
    die("");
}

?>
