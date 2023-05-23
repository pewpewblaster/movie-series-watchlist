<?php
// Load the XML file
$xml = simplexml_load_file('watchlist.xml');

// Check if the series ID is provided in the request
if (isset($_POST['delete_id'])) {
    $seriesId = $_POST['delete_id'];

    // Find the series with the provided ID in the XML
    $seriesToDelete = null;
    foreach ($xml->series_watched->series as $series) {
        if ((string) $series->attributes()['id'] === $seriesId) {
            $seriesToDelete = $series;
            break;
        }
    }

    // Delete the series if found
    if ($seriesToDelete !== null) {
        $dom = dom_import_simplexml($seriesToDelete);
        $dom->parentNode->removeChild($dom);
        // Save the modified XML back to the file
        $xml->asXML('watchlist.xml');
    }
}

// Redirect back to the watchlist page
header('Location: series.php');
exit();
?>
