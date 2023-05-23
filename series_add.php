<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input values
    $name = $_POST["name"];
    $watchedDate = $_POST["watched_date"];
    $season = $_POST["season"];
    $episode = $_POST["episode"];
    $rating = $_POST["rating"];
    $note = $_POST["note"];

    // Load the XML file
    $xml = simplexml_load_file('watchlist.xml');

    // Create a new series element
    $series = $xml->series_watched->addChild('series');

    // Set the series data
    $series->addChild('name', $name);
    $series->addChild('watched_date', $watchedDate);
    $series->addChild('season', $season);
    $series->addChild('episode', $episode);
    $series->addChild('rating', $rating);
    $series->addChild('note', $note);

    // Generate a unique ID for the series
    $id = uniqid();
    $series->addAttribute('id', $id);

    // Save the updated XML file
    $xml->asXML('watchlist.xml');

    // Redirect back to series.php
    header("Location: series.php");
    exit();
}
?>
