<!DOCTYPE html>
<html>

<head>
    <title>Watchlist - Need to Watch</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <script>
    function sortTable(column) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("watchlist-table");
        switching = true;
        dir = "asc";

        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("TR");

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;

                x = rows[i].getElementsByTagName("TD")[column];
                y = rows[i + 1].getElementsByTagName("TD")[column];

                if (dir === "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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
            <a class="flex-sm-fill text-sm-center nav-link" href="series.php">Series</a>
            <a class="flex-sm-fill text-sm-center nav-link active" href="towatch.php">To Watch</a>
        </nav>
        <br><br>
        <div class="row">
            <div class="col-md-12">
                <h3>Add movie/series to the watch list</h3>
                <form action="towatch_add.php" method="post">
                    <div class="form-group"> 
                        <label for="name">Name:</label>
                        <input class="form-control" type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select id="type" name="type">
                            <option value="movie">Movie</option>
                            <option value="series">Series</option>
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Add to Watchlist">
                </form>
            </div>
        </div>

        <br><br>
        <h2>Movies/Series I need to watch</h2>
        <form action="towatch_delete.php" method="post">
            <div class="form-group">
                <label for="delete_id">Enter ID to delete:</label>
                <input class="form-control" type="text" id="delete_id" name="delete_id" required>
            </div>
            <input class="btn btn-danger" type="submit" value="Delete">
        </form>

        <br><br>
        <table class="table" id="watchlist-table">
            <tr>
                <th onclick="sortTable(0)">Item Number</th>
                <th onclick="sortTable(1)">Type</th>
                <th onclick="sortTable(2)">Name</th>
                <th onclick="sortTable(3)">ID</th>
            </tr>


            <?php
        // Load the XML file
        $xml = simplexml_load_file('watchlist.xml');

        // Loop through each item in the "need_to_watch" section
        $items = [];
        foreach ($xml->need_to_watch->item as $item) {
            $type = $item->type;
            $name = $item->name;
            $id = $item['id'];

            // Add the item details to the array
            $items[] = [
                'type' => $type,
                'name' => $name,
                'id' => $id
            ];
        }
        
        // Sort the items based on column and direction
        function sortItems($column, $direction) {
            return function ($a, $b) use ($column, $direction) {
                $x = strtolower($a[$column]);
                $y = strtolower($b[$column]);
                
                if ($direction === "asc") {
                    return ($x <=> $y);
                } else {
                    return ($y <=> $x);
                }
            };
        }
        
        if (isset($_GET['sort'])) {
            $sortColumn = $_GET['sort'];
            $sortDirection = $_GET['dir'] === 'asc' ? 'asc' : 'desc';
            
            // Sort the items based on the specified column and direction
            usort($items, sortItems($sortColumn, $sortDirection));
        }

        // Display the sorted item details in the table
        $itemNumber = 1;
        // Display the sorted item details in the table
        $itemNumber = 1;
        foreach ($items as $item) {
            $type = $item['type'];
            $name = $item['name'];
            $id = $item['id'];

            echo "<tr>";
            echo "<td>{$itemNumber}</td>";
            echo "<td>{$type}</td>";
            echo "<td>{$name}</td>";
            echo "<td>{$id}</td>";
            echo "</tr>";

            $itemNumber++;
        }

        ?>
        </table>
    </div>
</body>

</html>