class SnackBarMixin {
  constructor() {
    // Create snackbar container if it doesn't exist
    if (!document.getElementById("snackbar-container")) {
      const container = document.createElement("div");
      container.id = "snackbar-container";
      container.style.position = "fixed";
      container.style.top = "20px";
      container.style.right = "20px";
      container.style.zIndex = "10000";
      container.style.maxWidth = "450px";
      document.body.appendChild(container);
    }
  }

  showMessage(message, type = "success", timeout = 3000) {
    // Create a Bootstrap alert element
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = "alert";
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      `;

    const container = document.getElementById("snackbar-container");
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
      alertDiv.classList.remove("show");
      alertDiv.classList.add("fade");
      setTimeout(() => alertDiv.remove(), 500); // Allow fade out
    }, timeout);
  }
}

export default SnackBarMixin
