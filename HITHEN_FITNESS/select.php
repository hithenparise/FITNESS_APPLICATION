<?php  
require_once 'config.php';

if (isset($_POST["employee_id"])) {  
    $output = '';  
    $connect = getDBConnection();  
    
    $employee_id = mysqli_real_escape_string($connect, $_POST["employee_id"]);
    $query = "SELECT * FROM tbl_creators WHERE id = '" . $employee_id . "'";  
    $result = mysqli_query($connect, $query);  
    
    $output .= '  
    <div class="table-responsive">  
        <table class="table table-bordered">';  
    
    while ($row = mysqli_fetch_array($result)) {  
        $output .= '  
            <tr>  
                <td width="30%"><label>Name</label></td>  
                <td width="70%">' . htmlspecialchars($row["name"]) . '</td>  
            </tr>  
            <tr>  
                <td width="30%"><label>Email</label></td>  
                <td width="70%">' . htmlspecialchars($row["email"]) . '</td>  
            </tr>  
            <tr>  
                <td width="30%"><label>Roll No</label></td>  
                <td width="70%">' . htmlspecialchars($row["roll"]) . ' </td>  
            </tr>  
            ';  
    }  
    
    $output .= "</table></div>";  
    echo $output;
    
    mysqli_close($connect);
}  
?>
