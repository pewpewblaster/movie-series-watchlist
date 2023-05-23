<?php
// Check if the delete form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID to delete
    $deleteId = $_POST['delete_id'];

    // Load the XML file
    $xml = simplexml_load_file('watchlist.xml');

    // Find the item with the matching ID and remove it
    foreach ($xml->need_to_watch->item as $item) {
        if ($item['id'] == $deleteId) {
            unset($item[0]);
            break;
        }
    }

    // Save the updated XML back to the file
    $xml->asXML('watchlist.xml');

    // Redirect back to the index.php after deletion
    header('Location: towatch.php');
    exit;
}
