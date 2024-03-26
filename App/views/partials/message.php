<?php if (isset($_SESSION['success_msg'])) { ?>
    <div class="message bg-green-100 p-3 my-3"> <?= $_SESSION['success_msg']; ?></div>
    <?php unset($_SESSION['success_msg']); ?>
<?php } ?>

<?php if (isset($_SESSION['error_msg'])) { ?>
    <div class="message bg-red-100 p-3 my-3"> <?= $_SESSION['error_msg']; ?></div>
    <?php unset($_SESSION['error_msg']); ?>
<?php } ?>