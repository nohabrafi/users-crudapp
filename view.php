<?php
require_once 'users/user-functions.php';
include 'partials/header.php';

// if there is no id
if (!isset($_GET['id'])) {
    header('Location: not-found.php');
}
// get user
$user = getUserById($_GET['id']);

if (!$user) {
    header('Location: not-found.php');
}
?>

<div class="container">
    <br>
    <p>
        <a href="index.php" class="btn btn-sm btn-outline-info">Go Back</a>
        <a href="update.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-secondary">Update</a>
        <a href="delete.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
    </p>

    <table class="table table-hover">
        <tbody>
            <tr>
                <th>Name:</th>
                <td><?php echo $user['name'] ?></td>
            </tr>
            <tr>
                <th>Username:</th>
                <td><?php echo $user['username'] ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo $user['email'] ?></td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td><?php echo $user['phone'] ?></td>
            </tr>
            <tr>
                <th>website:</th>
                <td><?php echo $user['website'] ?></td>
            </tr>
        </tbody>
    </table>

    <?php if (file_exists("users/images/" . $user['username'] . ".jpg")) : ?>
        <img src="users/images/<?php echo $user['username'] . ".jpg" ?>" height="400">
    <?php endif ?>
</div>



<?php include 'partials/footer.php' ?>