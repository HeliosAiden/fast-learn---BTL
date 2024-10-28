<?php if ($this->get_user_role() == 'Guest'): ?>
    <?php
    $this->render('blocks/guest/carrousel', $data);
    $this->render('blocks/guest/service', $data);
    $this->render('blocks/guest/category', $data);
    $this->render('blocks/guest/courses', $data);
    ?>
<?php else: ?>
    <?php if ($this->get_user_role() == 'Student'): ?>
        <?php
        require _DIR_ROOT . '/app/apis/Api.php';
        $course_api = new Api('Course');
        $course_api->get_controller()->render('/course/registered')
        ?>
    <?php endif ?>
    <?php if ($this->get_user_role() == 'Teacher'): ?>
        <?php
        require _DIR_ROOT . '/app/apis/Api.php';
        $course_api = new Api('Course');
        $course_api->get_controller()->render('/course/registered')
        ?>
    <?php endif ?>
    <?php if ($this->get_user_role() == 'Admin'): ?>
        <?php
        $this->render('home/admin');
        ?>
    <?php endif ?>
<?php endif ?>