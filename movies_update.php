<?php
// Check if the movie ID is provided
if (isset($_POST['update_id'])) {
    $movieID = $_POST['update_id'];

    // Load the XML file
    $xml = simplexml_load_file('watchlist.xml');

    // Search for the movie with the given ID
    $movieNode = $xml->xpath("//movie[@id='$movieID']");

    // Check if the movie exists
    if (!empty($movieNode)) {
        $movie = $movieNode[0];

        // Update the movie attributes if provided
        if (!empty($_POST['update_name'])) {
            $movie->name = $_POST['update_name'];
        }
        if (!empty($_POST['update_watched_date'])) {
            $movie->watched_date = $_POST['update_watched_date'];
        }
        if (!empty($_POST['update_rating'])) {
            $movie->rating = $_POST['update_rating'];
        }
        if (!empty($_POST['update_note'])) {
            $movie->note = $_POST['update_note'];
        }

        // Save the modified XML back to the file
        $xml->asXML('watchlist.xml');

        // Redirect back to movies.php
        header("Location: movies.php");
        exit();
    } else {
        // Movie with the given ID not found
        // Return error response
        http_response_code(404);
    }
} else {
    // No movie ID provided
    // Return error response
    http_response_code(400);
}
?>
