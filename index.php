<?php 
    if (isset($_POST['search'])){
        $response = "<ul><li>No data found</li></ul>";

        $connection = new mysqli('localhost','root', '', 'db_ajax_exercise');
        
        if(isset($_POST['q'])){
            $q = $connection->real_escape_string($_POST['q']);

            $sql = $connection->query("SELECT name FROM country WHERE name LIKE '%$q%'");

            if($sql->num_rows > 0){
                $response = "<ul>";

                while ($data = $sql->fetch_array()) {
                    $response .= "<li>".$data['name']."</li>";
                }
                $response .= "</ul>";
            }            
            exit($response);
        }else if(isset($_POST['cmb'])){
            $q = $connection->real_escape_string($_POST['cmb']);

            $sql = $connection->query("SELECT name FROM country WHERE name LIKE '%$q%'");

            if($sql->num_rows > 0){  

                while ($data = $sql->fetch_array()) {
                    $response = "<option value='".$data['name']."' >".$data['name']."</option>";
                }
            }
            
            exit($response);
        }


    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX EXERCISE</title>

    <style type="text/css">
        ul{
            float: left;
            list-style: none;
            padding: 0px;
            border: 1px solid black;
            margin-top: 0px;
        }

        input, ul{
            width: 350px;
        }

        li:hover{
            color: silver;
            background-color: #0088CC;
        }
    </style>
</head>
<body>


    <input type="text" placeholder="Search Query..." id="searchBox">

    <div id="response"></div>


    <select id="cmb_country">
        <option value="D">India</option>
        <option value="af">Afganistan</option>
        <option value="qa">Qatar</option>        
    </select>

    <select id="cmb_rescountry">
        
    </select>

    <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#searchBox").keyup(function() {
                var query = $("#searchBox").val();

                if (query.length > 0) {
                    $.ajax({
                        url: "index.php",
                        method: "POST",
                        data: {
                            search: 1,
                            q: query
                        },
                        success: function(data) {
                            $("#response").html(data);
                        },
                        dataType: "text"
                    });
                }
            });

            $("#cmb_country").change(function() {
                var query = $("#cmb_country").val();

                if (query.length > 0) {
                    $.ajax({
                        url: "index.php",
                        method: "POST",
                        data: {
                            search: 1,
                            cmb: query
                        },
                        success: function(data) {
                            console.log(data);
                            $("#cmb_rescountry").html(data);
                        },
                        dataType: "text"
                    });
                }
            });

            $(document).on('click','li', function(){
                var country = $(this).text();
                $("#searchBox").val(country);
                $("#response").html("");
            });


        });
    </script>


</body>
</html>