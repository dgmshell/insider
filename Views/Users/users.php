<?php
/** @var Users $data1 */
$users=$data1;


?>
    <a href="<?php echo router(); ?>users/new">New User</a><br>

<?php
    foreach($users as $user){

?>
        <a href="<?php echo router(); ?>permissions/assign/<?php echo $user['userId']; ?>"><?php echo $user['userEmail']; ?></a>
        <br>
        <?php
    }
?>