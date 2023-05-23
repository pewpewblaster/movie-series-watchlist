<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input values
    $name = $_POST["name"];
    $watchedDate = $_POST["watched_date"];
    $rating = $_POST["rating"];
    $note = $_POST["note"];

    // Load the XML file
    $xml = simplexml_load_file('watchlist.xml');

    // Create a new movie element
    $movie = $xml->movies_watched->addChild('movie');

    // Set the movie data
    $movie->addChild('name', $name);
    $movie->addChild('watched_date', $watchedDate);
    $movie->addChild('rating', $rating);
    $movie->addChild('note', $note);

    // Generate a unique ID for the movie
    $id = uniqid();
    $movie->addAttribute('id', $id);

    // Save the updated XML file
    $xml->asXML('watchlist.xml');

    // Redirect back to movies.php
    header("Location: movies.php");
    exit();
}
?>
