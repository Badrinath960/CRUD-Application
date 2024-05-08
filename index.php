<!-- /*  INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Todays story', 'Good vibes: \"Positivity always!\"\r\nHappiness: \"Life\'s too short not to be happy.\"\r\nGratitude: \"Simply grateful for today.\"\r\nMorning: \"Good morning, world!\"\r\nSelfie: \"I woke up like this.\"\r\nBeauty: \"Beauty begins the moment you decide to be yourself.\"\r\nJoy: \"Finding joy in the present leads to a fulfilling future.\"\r\nPurpose: \"Live your life with intention and purpose.\"\r\nDreams: \"Don\'t quit your daydream.\"', current_timestamp());

*/ -->


<?php
$insert = false;
$update = false;
$delete = false;

// Connect to the Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['titleEdit']) && isset($_POST['descriptionEdit']) && isset($_POST['snoEdit'])) {
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sno = $_POST['snoEdit'];

        // Update the record in the 'notes' table
        $sql = "UPDATE notes SET title = '$title', description = '$description' WHERE sno = '$sno'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $update = true;
        } else {
            // Handle update failure
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        $title = $_POST["title"];
        $description = $_POST["description"];

        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            // Handle insert failure
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="style.css">

  <title> Note App</title>
</head>

<body>



<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php" method = "post">
        <input type="hidden" name= "snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="title" class="form-label"> <b> Note Title : </b></label>
        <input type="title" class="form-control" id="titleEdit" name= "titleEdit">

      </div>
      <div>
        <label for="text"> <b>Notes Discriptions : </b></label>
      </div>
      <div class="form-floating">
        <textarea class="form-control" name = "descriptionEdit" placeholder="Leave a comment here" id="descriptionEdit"
          style="height: 100px"></textarea>
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Update Notes</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="/crud/logo.png" height = "30px" alt="SnapNotes"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Conatct Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Updates</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  
  <?php
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your Note Added Successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
    <?php
    if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your Note updated Successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
    <?php
    if($delete){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your Note deleted Successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
  <div class="container my-3">
    <h2>Add Notes</h2>
    <br>
    <form action="/crud/index.php" method = "post">
      <div class="mb-3">
        <label for="title" class="form-label"> <b> Note Title : </b></label>
        <input type="title" class="form-control" name= "title" id="exampleInputEmail1">

      </div>
      <div>
        <label for="text"> <b>Notes Discriptions : </b></label>
      </div>
      <div class="form-floating">
        <textarea class="form-control" name = "description" placeholder="Leave a comment here" id="floatingTextarea2"
          style="height: 100px"></textarea>
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Add Notes</button>
    </form>

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sr. No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Time Stamp</th>
        </tr>
      </thead>
      <tbody>
      <?php
    $sql = "SELECT * FROM notes";
    $result = mysqli_query($conn, $sql);
    $sno = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $sno++;
        echo "
        <tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>
                <div class='edit d-flex justify-content-between'>
                <button type='button' class='btn btn-primary btn-lg me-2' id='". $row['sno']. "' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button>
                <div class='edit d-flex justify-content-between'>
                <button type='button' class='delete btn btn-primary btn-lg me-2' id=d'". $row['sno']. "' data-bs-toggle='modal' data-bs-target='#editModal'>Delete</button>
            </td>
        </tr>";
    }
?>

        <!-- <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr> -->
      
      </tbody>
    </table>
  </div>


  
  <div class="container">
  <?php
  /*
  $sql = "SELECT * FROM notes";
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)){
    echo $row['sno'] . ". Hello " . $row['title'] . "   is " . $row['description'];
    echo "<br>";
  }
  */
  ?>
</div>


  </div>

  </div>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="crossorigin="anonymous"></script>

  <!-- Ensure jQuery is loaded before DataTables -->
   <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- Include DataTables JavaScript library -->
  <script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable(); // Assuming #myTable is the ID of the table you want to turn into a DataTable
  });
  </script>
  <!-- <script>
   edits = document.getElementByClassName('edit');
   Arrey.from(edits).forEach((element)=>{
    element.addEventListner("click", (e)=>{
      console.log("edit", e);
    })
  }) -->
  <script>
   document.addEventListener('DOMContentLoaded', function() {
    // Get all elements with class name 'edit'
    var edits = document.getElementsByClassName('edit');

    // Convert HTMLCollection to Array and attach click event listener to each 'edit' button
    Array.from(edits).forEach(function(element) {
        element.addEventListener("click", function(e) {
            e.preventDefault();

            // Find the closest table row (tr) containing the clicked button
            var tr = e.target.closest('tr');

            if (tr) {
                // Retrieve title and description from the table row (td elements)
                var titleCell = tr.querySelector("td:nth-child(2)"); // Assuming title is in the second td
                var descriptionCell = tr.querySelector("td:nth-child(3)"); // Assuming description is in the third td

                if (titleCell && descriptionCell) {
                    var title = titleCell.innerText;
                    var description = descriptionCell.innerText;

                    // Set the values in the edit modal input fields
                    document.getElementById('titleEdit').value = title;
                    document.getElementById('descriptionEdit').value = description;

                    // Extract and set the ID (sno) from the button's ID attribute
                    var sno = e.target.id;
                    document.getElementById('snoEdit').value = sno;

                    // Toggle Bootstrap modal using jQuery (assuming jQuery is loaded)
                    $('#editModal').modal('toggle');
                } else {
                    console.error("Title or description cells not found.");
                }
            } else {
                console.error("Parent table row (tr) not found.");
            }
        });
    });

    // Attach click event listener to delete buttons
    var deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach(function(element) {
        element.addEventListener("click", function(e) {
            e.preventDefault();

            // Extract sno from the button's ID (assuming ID is like 'd123')
            var sno = e.target.id.substr(1);

            // Confirm deletion
            if (confirm("Are you sure you want to delete this note?")) {
                console.log("User confirmed deletion of sno: " + sno);

                // Redirect to delete endpoint (replace with appropriate URL)
                window.location = "/crud/index.php?delete=" + sno;
            } else {
                console.log("Deletion canceled by user.");
            }
        });
    });
});

</script>




</body>

</html>