<!DOCTYPE html>
<html>

<head>
    <title>Watchlist - Movies Watched</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
    function sortTable(columnIndex) {
        var table = document.getElementById("seriesTable");
        var rows = Array.from(table.rows).slice(1); // Exclude the header row
        var isAscending = table.getAttribute("data-sort") !== columnIndex.toString();

        rows.sort(function(a, b) {
            var rowDataA = a.cells[columnIndex].textContent.trim();
            var rowDataB = b.cells[columnIndex].textContent.trim();

            if (columnIndex === 0 || columnIndex === 3) {
                rowDataA = parseFloat(rowDataA);
                rowDataB = parseFloat(rowDataB);
            }

            if (rowDataA > rowDataB) {
                return isAscending ? 1 : -1;
            } else if (rowDataA < rowDataB) {
                return isAscending ? -1 : 1;
            } else {
                return 0;
            }
        });

        // Clear the table body
        while (table.rows.length > 1) {
            table.deleteRow(1);
        }

        // Append the sorted rows to the table in the desired order
        for (var i = 0; i < rows.length; i++) {
            table.appendChild(rows[i]);
        }

        // Update the data-sort attribute to track the current sorted column
        table.setAttribute("data-sort", isAscending ? columnIndex.toString() : "");

        // Remove the sort indicator classes from all column headers
        var headers = table.getElementsByTagName("th");
        for (var i = 0; i < headers.length; i++) {
            headers[i].classList.remove("sort-asc", "sort-desc");
        }

        // Add the appropriate sort indicator class to the clicked column header
        var clickedHeader = headers[columnIndex];
        clickedHeader.classList.add(isAscending ? "sort-asc" : "sort-desc");
    }
    </script>



</head>

<body>
    <div class="container">
            <nav class="nav nav-pills flex-column flex-sm-row">
                <a class="flex-sm-fill text-sm-center nav-link active" aria-current="page" href="movies.php">Movies</a>
                <a class="flex-sm-fill text-sm-center nav-link" href="series.php">Series</a>
                <a class="flex-sm-fill text-sm-center nav-link" href="towatch.php">To Watch</a>
            </nav>

            <br><br>

            <div class="row">
                <div class="col-md-6">
                    <h2>Add New Movie</h2>
                    <form action="movies_add.php" method="post">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="watched_date">Date Watched:</label>
                            <input class="form-control" type="date" id="watched_date" name="watched_date" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <input class="form-control" type="number" id="rating" name="rating" step="0.1" min="0"
                                max="10" required>
                        </div>
                        <div class="form-group">
                            <label for="note">Note:</label>
                            <textarea class="form-control" id="note" name="note"></textarea>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Add Movie">
                    </form>
                    <br><br>
                </div>

                <div class="col-md-6">
                    <h2>Update Existing Movie</h2>
                    <form action="movies_update.php" method="post">

                        <div class="form-group">
                            <label for="update_id">Movie ID:</label>
                            <input class="form-control" type="text" id="update_id" name="update_id" required>
                        </div>
                        <div class="form-group">
                            <label for="update_name">Name:</label>
                            <input class="form-control" type="text" id="update_name" name="update_name">
                        </div>
                        <div class="form-group">
                            <label for="update_watched_date">Date Watched:</label>
                            <input class="form-control" type="date" id="update_watched_date" name="update_watched_date">
                        </div>
                        <div class="form-group">
                            <label for="update_rating">Rating:</label>
                            <input class="form-control" type="number" id="update_rating" name="update_rating" step="0.1"
                                min="0" max="10">
                        </div>
                        <div class="form-group">
                            <label for="update_note">Note:</label>
                            <textarea class="form-control" id="update_note" name="update_note"></textarea>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Update Movie">
                    </form>
                    <br><br>
                </div>
            </div>
            <h2>Movies I Watched</h2>
            <form action="movise_delete.php" method="post">
                <div class="form-group">
                    <label for="delete_id">Movie ID:</label>
                    <input class="form-control" type="text" id="delete_id" name="delete_id" required>
                </div>
                <input type="submit" class="btn btn-danger" value="Delete Movie">
            </form>

            <br><br>
            <table class="table" id="seriesTable">
                <tr>
                    <th onclick="sortTable(0)">Item Number</th>
                    <th onclick="sortTable(1)">Name</th>
                    <th onclick="sortTable(2)">Date Watched</th>
                    <th onclick="sortTable(3)">Rating</th>
                    <th>Note</th>
                    <th onclick="sortTable(5)">Movie ID</th>

                </tr>
                <?php
            // Load the XML file
            $xml = simplexml_load_file('watchlist.xml');

            // Loop through each movie in the "movies_watched" section
            $itemNumber = 1;
            foreach ($xml->movies_watched->movie as $movie) {
                $name = $movie->name;
                $watchedDate = $movie->watched_date;
                $rating = $movie->rating;
                $note = $movie->note;
                $id = $movie['id'];

                // Display the movie details in the table
                echo "<tr>";
                echo "<td>{$itemNumber}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$watchedDate}</td>";
                echo "<td>{$rating}</td>";
                echo "<td>{$note}</td>";
                echo "<td>{$id}</td>";
                echo "</tr>";

                $itemNumber++;
            }
            ?>
            </table>
        </div>
</body>

</html>