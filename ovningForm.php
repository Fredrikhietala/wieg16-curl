<?php
require_once('ovningDb.php');
?>
<html>
<body>
    <form method="post" action="ovningForm.php">
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="number" name="age" placeholder="Age"><br>
        <input type="text" name="occupation" placeholder="Occupation"><br>
        <button type="submit" name="submit" value="submit">Submit</button><br>
    </form>
</body>
</html>
