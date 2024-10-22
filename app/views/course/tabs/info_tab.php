<div class="tab-pane fade active show" id="info-tab" role="tabpanel" aria-labelledby="li-info-tab">
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group form-group-default">
                    <label>Tên khóa học</label>
                    <span><b><?php echo $current_course['name'] ?></b></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-default">
                    <label>Môn học</label>
                    <span><b><?php echo $subject_name ?></b></span>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group form-group-default">
                    <label>Giáo viên</label>
                    <span><b><?php echo $teacher_name ?></b></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-default">
                    <label>Email liên hệ</label>
                    <span><b><?php echo $teacher_email ?></b></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Ngày bắt đầu</label>
                        <span><b><?php echo $current_course['start_date'] ?></b></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Ngày kết thúc</label>
                        <span><b><?php echo $current_course['end_date'] ?></b></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Học phí</label>
                        <span><b><?php echo number_format($current_course['fee'], 0, '.', ',') ?> VNĐ</b></span>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-1">
            <div class="col-md-12">
                <div class="form-group form-group-default">
                    <label>Giới thiệu khóa học</label>
                    <p><?php echo $current_course['description'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>