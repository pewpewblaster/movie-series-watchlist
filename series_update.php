<?php
// Check if the series ID is provided
if (isset($_POST['update_id'])) {
    $seriesID = $_POST['update_id'];

    // Load the XML file
    $xml = simplexml_load_file('watchlist.xml');

    // Search for the series with the given ID
    $seriesNode = $xml->xpath("//series[@id='$seriesID']");

    // Check if the series exists
    if (!empty($seriesNode)) {
        $series = $seriesNode[0];

        // Update the series attributes if provided
        if (!empty($_POST['update_name'])) {
            $series->name = $_POST['update_name'];
        }
        if (!empty($_POST['update_watched_date'])) {
            $series->watched_date = $_POST['update_watched_date'];
        }
        if (!empty($_POST['update_season'])) {
            $series->season = $_POST['update_season'];
        }
        if (!empty($_POST['update_episode'])) {
            $series->episode = $_POST['update_episode'];
        }
        if (!empty($_POST['update_rating'])) {
            $series->rating = $_POST['update_rating'];
        }
        if (!empty($_POST['update_note'])) {
            $series->note = $_POST['update_note'];
        }

        // Save the modified XML back to the file
        $xml->asXML('watchlist.xml');

        // Redirect back to series.php
        header("Location: series.php");
        exit();
    } else {
        // Series with the given ID not found
        // Return error response
        http_response_code(404);
    }
} else {
    // No series ID provided
    // Return error response
    http_response_code(400);
}
?>
