<!DOCTYPE html>
<html>

<head>
    <title>Watchlist - Series Watched</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <script>
    // Sorting function
    function sortTable(columnIndex) {
        if (columnIndex === 6 || columnIndex === 3 || columnIndex === 4) {
            return; // Exclude sorting for Note, Season, and Episode columns
        }

        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("seriesTable");
        switching = true;
        dir = "asc"; // Set the default sort direction to ascending

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                var xValue = x.textContent || x.innerText;
                var yValue = y.textContent || y.innerText;

                // Compare values based on the column index
                if (columnIndex === 0 || columnIndex === 5) {
                    // Sort by numeric value
                    xValue = parseFloat(xValue);
                    yValue = parseFloat(yValue);
                } else if (columnIndex === 1 || columnIndex === 2 || columnIndex === 7) {
                    // Sort alphabetically or by date
                    xValue = xValue.toLowerCase();
                    yValue = yValue.toLowerCase();
                }

                if (dir === "asc") {
                    if (xValue > yValue) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (xValue < yValue) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    </script>
</head>

<body>
    <div class="container">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="movies.php">Movies</a>
            <a class="flex-sm-fill text-sm-center nav-link active" href="series.php">Series</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="towatch.php">To Watch</a>
        </nav>
        <br><br>

        <div class="row">
            <div class="col-md-6">
                <h2>Add New Series</h2>
                <form action="series_add.php" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="watched_date">Date Watched:</label>
                        <input type="date" class="form-control" id="watched_date" name="watched_date" required>
                    </div>
                    <div class="form-group">
                        <label for="season">Season:</label>
                        <input type="number" class="form-control" id="season" name="season" required>
                    </div>
                    <div class="form-group">
                        <label for="episode">Episode:</label>
                        <input type="number" class="form-control" id="episode" name="episode" required>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0" max="10"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="note">Note:</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Series">
                </form>
            </div>

            <div class="col-md-6">
                <form action="series_update.php" method="post"></form>
                <h2>Update Existing Series</h2>
                <form action="series_update.php" method="post">
                    <div class="form-group">
                        <label for="update_id">Series ID:</label>
                        <input type="text" class="form-control" id="update_id" name="update_id" required>
                    </div>
                    <div class="form-group">
                        <label for="update_name">Name:</label>
                        <input type="text" class="form-control" id="update_name" name="update_name">
                    </div>
                    <div class="form-group">
                        <label for="update_watched_date">Date Watched:</label>
                        <input type="date" class="form-control" id="update_watched_date" name="update_watched_date">
                    </div>
                    <div class="form-group">
                        <label for="update_season">Season:</label>
                        <input type="number" class="form-control" id="update_season" name="update_season">
                    </div>
                    <div class="form-group">
                        <label for="update_episode">Episode:</label>
                        <input type="number" class="form-control" id="update_episode" name="update_episode">
                    </div>
                    <div class="form-group">
                        <label for="update_rating">Rating:</label>
                        <input type="number" class="form-control" id="update_rating" name="update_rating" step="0.1"
                            min="0" max="10">
                    </div>
                    <div class="form-group">
                        <label for="update_note">Note:</label>
                        <textarea class="form-control" id="update_note" name="update_note"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Update Series">
                </form>
                <br><br>
            </div>

        </div>

        <h2>Series I Watched</h2>
        <form action="series_delete.php" method="post">
            <div class="form-group">
                <label for="delete_id">Series ID:</label>
                <input type="text" class="form-control" id="delete_id" name="delete_id" required>
            </div>
            <input type="submit" class="btn btn-danger" value="Delete Series">
        </form>
        <br><br>
        <table class="table" id="seriesTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Item Number</th>
                    <th onclick="sortTable(1)">Name</th>
                    <th onclick="sortTable(2)">Date Watched</th>
                    <th>Season</th>
                    <th>Episode</th>
                    <th onclick="sortTable(5)">Rating</th>
                    <th>Note</th>
                    <th onclick="sortTable(7)">Series ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Load the XML file
                    $xml = simplexml_load_file('watchlist.xml');

                    // Loop through each series in the "series_watched" section
                    $itemNumber = 1;
                    foreach ($xml->series_watched->series as $series) {
                        $name = $series->name;
                        $watchedDate = $series->watched_date;
                        $season = $series->season;
                        $episode = $series->episode;
                        $rating = $series->rating;
                        $note = $series->note;
                        $id = $series['id'];

                        // Display the series details in the table
                        echo "<tr>";
                        echo "<td>{$itemNumber}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$watchedDate}</td>";
                        echo "<td>{$season}</td>";
                        echo "<td>{$episode}</td>";
                        echo "<td>{$rating}</td>";
                        echo "<td>{$note}</td>";
                        echo "<td>{$id}</td>";
                        echo "</tr>";

                        $itemNumber++;
                    }
                    ?>
            </tbody>
        </table>
    </div>
</body>

</html>