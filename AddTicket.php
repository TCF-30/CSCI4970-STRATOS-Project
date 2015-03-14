<html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Add Ticket</title>
        <link rel="stylesheet" type="text/css" href="style.css"> 
    </head>

    <body>
        <?php include 'Header.php'; ?>
        <?php include 'MenuBar.php'; ?>

        <br>
        <br>

        <form id="Add" name="AddTicket" method="post" class="dark-matter" action="ATForm.php">
            <h1>Ticket Adding Form
                <span>Please fill all the fields.</span>
            </h1>
            <p>
                <label for="textfield">Title:</label>
                <input type="text" placeholder="Enter Subject" name="title" id="title">

                <label for="textfield">Description:</label>
                <textarea id="description" placeholder="Enter details about the ticket" name="des"></textarea>

                <label for="textfield">Customer:</label>
                <select name="select" id="select" size="1">
                    <option value="Please Select">Please Select</option>
                     <!--<!Manually making dropdown because need to display more than one column -->
                    <?php
                    $con = mysqli_connect("127.0.0.1", "root", "", "stratos");
                        if (mysqli_connect_errno($con)) {
                            echo "Failed to connect to MySQL DB: " . mysqli_connect_errno();
                        } else {
                            $query = "SELECT * FROM  stprsninst";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo "<option value=\"{$row[pid]}\">{$row[fname]} {$row[lname]}</option>\n";
                            }
                        }                    
                    ?>
                </select>

                <label for="select">Assign To:</label>
                <select name="select" id="select" size="1">
                    <option value="Please Select">Please Select</option>
                    <?php
                    getMenu('stuserinst', 'pid', 'user');
                    ?>
                </select> 

                <label for="select">Category:</label>
                <select name="select" id="select" size="1">
                    <option value="Please Select">Please Select</option>
                    <?php
                    getMenu('category', 'cid', 'name');
                    ?>
                </select>  
                <label for="select">Affected Level:</label>
                <select name="select" id="select" size="1">
                    <option value="Please Select">Please Select</option>
                    <?php
                    getMenu('stafflvlconf', 'aff_level', 'name');
                    ?>
                </select>

                <label for="select">Severity:</label>
                <select name="select" id="select" size="1">
                    <option value="Please Select">Please Select</option>
                    <?php
                    getMenu('stsvrlvlconf', 'severity', 'name');
                    ?>
                </select>

            <label for="textfield">Location:</label>
            <input type="text" placeholder="Enter Room Number" name="location" id="location">

            <label for="textfield">Estimated Hours:</label>
            <input type="number" placeholder="Enter Hours" name="estHrs" id="estHrs">        
            <br>
            <labelc>
                <input type="submit" class="button" value="Add Ticket" id="add" name="action">
            </labelc>
            <labelc>
                <input type="submit" class="button" value="Go Back" name="action" onclick="location.href='Tickets.php'">
            </labelc>
        </form>
    </body>
</html>

<?php
function getMenu($table, $column1, $column2) {
    $con = mysqli_connect("127.0.0.1", "root", "", "stratos");
    if (mysqli_connect_errno($con)) {
        echo "Failed to connect to MySQL DB: " . mysqli_connect_errno();
    } else {
        $query = "SELECT * FROM " . $table;
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<option value=\"{$row[$column1]}\">{$row[$column2]}</option>\n";
        }
    }
}
?>