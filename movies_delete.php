<?php
// Load the XML file
$xml = simplexml_load_file('watchlist.xml');

// Check if the movie ID is provided in the request
if (isset($_POST['delete_id'])) {
    $movieId = $_POST['delete_id'];

    // Find the movie with the provided ID in the XML
    $movieToDelete = null;
    foreach ($xml->movies_watched->movie as $movie) {
        if ((string) $movie->attributes()['id'] === $movieId) {
            $movieToDelete = $movie;
            break;
        }
    }

    // Delete the movie if found
    if ($movieToDelete !== null) {
        $dom = dom_import_simplexml($movieToDelete);
        $dom->parentNode->removeChild($dom);
        // Save the modified XML back to the file
        $xml->asXML('watchlist.xml');
    }
}

// Redirect back to the watchlist page
header('Location: movies.php');
exit();
?>
