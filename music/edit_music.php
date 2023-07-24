<?php
include 'db_connect.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $qry = $conn->query("SELECT * FROM uploads WHERE id = " . $id)->fetch_array();

    if ($qry) {
        foreach ($qry as $k => $v) {
            if ($k == 'title')
                $k = 'mtitle';
            $$k = $v;
        }
    } else {
        echo 'Record not found.';
    }
}

include 'new_music.php';
?>
