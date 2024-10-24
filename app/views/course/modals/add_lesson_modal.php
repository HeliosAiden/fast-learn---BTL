<div class="modal" id="add-lesson-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm bài học</h5>
                <button type="button" class="btn-close close_add_modal"></button>
            </div>
            <div class="modal-body">
                <!-- Lesson Name (Required) -->
                <div class="mb-3">
                    <label for="lesson_add_name" class="form-label">Tên bài học<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="lesson_add_name" name="lesson_add_name" required>
                    <div class="invalid-feedback">
                        Vui lòng cung cấp tên của bài học
                    </div>
                </div>

                <!-- Lesson Description (Optional) -->
                <div class="mb-3">
                    <label for="lesson_add_description" class="form-label">Mô tả khóa học</label>
                    <textarea class="form-control" id="lesson_add_description" name="lesson_add_description" rows="3"></textarea>
                </div>

                <!-- Lesson Video File or URL (Optional) -->
                <div class="mb-3">
                    <div class="form-group">

                        <label for="lesson_add_description" class="form-label">Tải lên video hoặc nhập đường link</label>
                        <div class="selectgroup w-100 mb-2">
                            <label class="selectgroup-item">
                                <input type="radio" name="videoInputType" id="uploadVideo" autocomplete="off" class="selectgroup-input" checked>
                                <span class="selectgroup-button">Upload video</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="videoInputType" id="inputURL" autocomplete="off" class="selectgroup-input">
                                <span class="selectgroup-button">Input Url</span>
                            </label>
                        </div>

                        <!-- Upload Video Input (Hidden by default) -->
                        <div id="uploadInput" class="input-group mt-2">
                            <input type="file" class="form-control" id="videoUpload" accept="video/*" style="display: none;">
                            <label for="uploadImg2" id="uploadBtn" class="label-input-file btn btn-black btn-round">
                                <span class="btn-label">
                                    <i class="fa fa-file-image"></i>
                                </span>
                                Tải video lên
                            </label>
                            <div id="videoName" class="mt-3"></div>
                        </div>

                        <!-- Input URL Field (Hidden by default) -->
                        <div id="urlInput" class="input-group mt-2" style="display: none; margin: 0">
                            <label for="videoURL" class="input-group-text">Dán đường dẫn vào đây</label>
                            <input type="text" class="form-control" id="videoURL" placeholder="https://example.com/video">
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_add_modal">Đóng</button>
                <button type="button" id="add_lesson" class="btn btn-success">Tạo bài học</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";

    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>');

    let useUploadInput, useUrlInput = false;


    function toggleInputFields() {
        const uploadInput = document.getElementById('uploadInput');
        const urlInput = document.getElementById('urlInput');

        // Check which radio button is checked
        if (document.getElementById('uploadVideo').checked) {
            uploadInput.style.display = 'flex';
            useUploadInput = true;
            urlInput.style.display = 'none';
            useUrlInput = false;
        } else if (document.getElementById('inputURL').checked) {
            urlInput.style.display = 'flex';
            useUrlInput = true;
            uploadInput.style.display = 'none';
            useUploadInput = false;
        } else {
            uploadInput.style.display = 'none';
            useUploadInput = false;
            urlInput.style.display = 'none';
            useUrlInput = false;
        }
    }

    function openAddLessonModal() {
        var addModal = new bootstrap.Modal(document.getElementById('add-lesson-modal'));
        toggleInputFields()
        addModal.show();
    }

    function closeAddLessonModal() {
        var addModal = bootstrap.Modal.getInstance(document.getElementById('add-lesson-modal'));
        addModal.hide();
    }


    const submitCreateLesson = async () => {
        const name = document.getElementById('lesson_add_name').value;
        const description = document.getElementById('lesson_add_description').value;
        const course_id = '<?php echo $current_course['id'] ?>';
        let url = 'app/apis/course_lesson.php';

        const formData = new FormData();

        const fileInput = document.getElementById('videoUpload');

        if (fileInput.files.length > 0 && useUploadInput) {
            const formData = new FormData();
            formData.append('uploaded_file', fileInput.files[0]);
            formData.append('name', name);
            formData.append('description', description);
            formData.append('course_id', course_id);

            const response = await httpMixin.postMixin(url, formData)
            if (response.status == 'success') {
                swal({
                    title: "Thêm bài học thành công!",
                    icon: "success",
                    buttons: {
                        confirm: {
                            text: "Xác nhận",
                            value: true,
                            visible: true,
                            className: "btn btn-success",
                            closeModal: true,
                        },
                    },
                });
                closeAddLessonModal()
                window.location.reload()
            } else {
                swal(response.message ?? "Thêm bài học thất bại!", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                            closeModal: true,
                            visible: true
                        },
                    },
                });
            }
        }
        if (useUrlInput) {
            let video_url = document.getElementById('videoURL').value;

            let data = {
                'name': name,
                'course_id': course_id,
                'description': description,
                'video_url': video_url
            }

            const response = await httpMixin.postMixin(url, data)
            if (response.status == 'success') {
                swal({
                    title: "Thêm bài học thành công!",
                    icon: "success",
                    buttons: {
                        confirm: {
                            text: "Xác nhận",
                            value: true,
                            visible: true,
                            className: "btn btn-success",
                            closeModal: true,
                        },
                    },
                });
                closeAddLessonModal()
                window.location.reload()
            } else {
                swal(response.message ?? "Thêm bài học thất bại!", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                            closeModal: true,
                            visible: true
                        },
                    },
                });
            }
        }
    }

    $(document).ready(function() {
        document.getElementById('open_add_lesson_modal').addEventListener('click', openAddLessonModal)
        document.getElementById('uploadVideo').addEventListener('click', toggleInputFields)
        document.getElementById('inputURL').addEventListener('click', toggleInputFields)
        document.querySelectorAll('.close_add_modal').forEach(btn => {
            btn.addEventListener('click', closeAddLessonModal)
        })
        document.getElementById('add_lesson').addEventListener('click', () => {
            closeAddLessonModal()
            submitCreateLesson()
        })
        const uploadBtn = document.getElementById('uploadBtn');
        const fileInput = document.getElementById('videoUpload');
        const fileNameDisplay = document.getElementById('videoName');

        uploadBtn.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            if (file) {
                fileNameDisplay.textContent = `Selected file: ${file.name}`;
            } else {
                fileNameDisplay.textContent = 'No file selected';
            }
        });

    })
</script>