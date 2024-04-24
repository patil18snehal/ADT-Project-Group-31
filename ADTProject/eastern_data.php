<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian States</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h2>Select State:</h2>
    <select id="stateDropdown">
        <option value="">Select State</option>
    </select>

    <script>
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "fetch_states.php",
                dataType: "json",
                success: function(data){
                    $.each(data, function(index, value) {
                        $('#stateDropdown').append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        });
    </script>
</body>
</html>
