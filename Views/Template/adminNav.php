<div class="navbar">
    <div class="navbar-content">
        <div class="left">
            <?php 
          
            if (isset($_SESSION['permissions'][5]['r']) && $_SESSION['permissions'][5]['r'] === 1): ?>
                <a href="<?php echo router(); ?>dashboard">Dashboard</a>
            <?php endif; ?>

            <?php 
            if (isset($_SESSION['permissions'][4]['r']) && $_SESSION['permissions'][4]['r'] === 1): ?>
                <a href="<?php echo router(); ?>users">Usuarios</a>
            <?php endif; ?>

            <?php 
            if (isset($_SESSION['permissions'][3]['r']) && $_SESSION['permissions'][3]['r'] === 1): ?>
                <a href="<?php echo router(); ?>roles">Roles</a>
            <?php endif; ?>

            <?php 
            if (isset($_SESSION['permissions'][2]['r']) && $_SESSION['permissions'][2]['r'] === 1): ?>
                <a href="<?php echo router(); ?>permissions">Permissions</a>
            <?php endif; ?>

            <?php 
            if (isset($_SESSION['permissions'][1]['r']) && $_SESSION['permissions'][1]['r'] === 1): ?>
                <a href="<?php echo router(); ?>modules">Modules</a>
            <?php endif; ?>
        </div>
        <div class="right">
        <a href="<?php echo router(); ?>logout">Log Out</a>
        </div>
    </div>
</div>


