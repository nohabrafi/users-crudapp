<?php
require 'users/user-functions.php';

synchronizeData();
$users = getAllUsers();

include 'partials/header.php';
?>

<div class="container">

    <br>
    <p>
        <a href="create.php" class="btn btn-primary btn-lg btn-block">Add User</a>
    </p>


    <table class="table">
        <thead>
            <tr>
                <th scope="col">Profile Picture</th>
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">website</th>
                <th scope="col">Functions</th>
            </tr>
        </thead>
        <tbody>
        <?php if($users) : ?>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td>
                        <?php if(file_exists("users/images/". $user['username'] . ".jpg")) : ?>
                        <img src="users/images/<?php echo $user['username'] . ".jpg"?>" height="80">
                        <?php endif ?>
                    </td>
                    <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['username'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['phone'] ?></td>
                    <td><?php echo $user['website'] ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-info">View</a>
                        <a href="update.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-secondary">Update</a>
                        <a href="delete.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>



<?php include 'partials/footer.php';
