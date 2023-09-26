<label for="offence_description">Offence Description:</label><br>
  <select name="offence_description" id="offence_description">
    <?php
    // Connect to the database
    require("db.inc.php");

      $conn = mysqli_connect($servername, $username, $password, $dbname);   
    
    // Select the Offence_description column from the Offence table
    $sql = "SELECT DISTINCT Offence_description FROM Offence";
    $result = mysqli_query($conn, $sql);
    
    // Loop through the results and create an option element for each row
    while ($row = mysqli_fetch_assoc($result)) {
      $offence_description = $row['Offence_description'];
      echo "<option value='$offence_description'>$offence_description:</option>";
    }
    ?>
  </select>
</form>