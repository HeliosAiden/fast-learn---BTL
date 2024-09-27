<h2 class="text-center mb-4">User Table</h2>
<div class="container mt-5">
    <div id="table-container"></div>
</div>
<script type="module">
    import httpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import TableMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/table.js' ?>";
    let url = "<?php echo _WEB_ROOT . '/app/apis/user.php' ?>"
    let response = await httpMixin.getMixin(url)
    let data = response.data

    const tableMixin = new TableMixin(data, 5);
    tableMixin.render(document.getElementById('table-container'));
</script>