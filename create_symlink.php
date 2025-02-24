<?php

try {
    $target = __DIR__ . '/home/ami.penjamu.ung.ac.id/ami-ung/storage/app/public';
    $link = __DIR__ . '/home/ami.penjamu.ung.ac.id/public_html/storage';

    if (file_exists($link)) {
        echo "Symlink already exists at: $link";
    } else {
        if (symlink($target, $link)) {
            echo "Symlink created successfully!";
        } else {
            echo "Failed to create symlink.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
