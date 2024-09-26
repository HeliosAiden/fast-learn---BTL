// Load content dynamically
function loadContent(page) {
  $("#mainContent").load(page, function (response, status, xhr) {
    if (status == "error") {
      $(this).html(
        `<h3>Error loading content</h3><p>Trying to nagigate to ${page}</p>`
      );
    }
  });
}
