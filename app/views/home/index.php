<?php if($this -> get_user_role() == 'Guest'): ?>
    <?php
    $this->render('blocks/guest/carrousel', $data);
    $this->render('blocks/guest/service', $data);
    $this->render('blocks/guest/category', $data);
    $this->render('blocks/guest/courses', $data);
    ?>
<?php else: ?>
    <?php if($this -> get_user_role() == 'Student'): ?>

    <?php endif ?>
    <?php if($this -> get_user_role() == 'Teacher'): ?>

    <?php endif ?>
    <?php if($this -> get_user_role() == 'Admin'): ?>
        
    <?php endif ?>
<?php endif ?>