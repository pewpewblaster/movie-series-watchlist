<?php
// Get the form input data
$name = $_POST['name'];
$type = $_POST['type'];

// Load the XML file
$xml = simplexml_load_file('watchlist.xml');

// Generate a unique ID
$id = uniqid();

// Create a new item element
$item = $xml->need_to_watch->addChild('item');

// Set the attributes for the item
$item->addAttribute('id', $id);
$item->addChild('name', $name);
$item->addChild('type', $type);

// Save the modified XML file
$xml->asXML('watchlist.xml');

// Redirect back to the need-to-watch page
header('Location: towatch.php');
exit;
?>
