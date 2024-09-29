class TableMixin {
  constructor(data, rowsPerPage, defaultHeader = []) {
    this.data = data; // Data to display in the table (array of objects)
    this.rowsPerPage = rowsPerPage; // Number of rows per page
    this.currentPage = 1; // Current page being displayed
    this.totalPages = Math.ceil(this.data.length / this.rowsPerPage); // Calculate total pages

    this.tableContainer = document.createElement("div"); // Container for the table
    this.paginationContainer = document.createElement("div"); // Container for pagination controls
    this.defaultHeader = defaultHeader;
  }

  // Method to generate and display the table
  renderTable() {
    // Clear the previous table
    this.tableContainer.innerHTML = "";

    // Create the table
    const table = document.createElement("table");
    table.classList.add(
      "table",
      "table-striped",
      "table-hover",
      "table-bordered"
    ); // Add Bootstrap table classes

    // Create table headers (from the keys of the first data object)
    const thead = document.createElement("thead");
    const headersRow = document.createElement("tr");

    let headers = this.defaultHeader;
    if (this.data.length !== 0) {
      headers = Object.keys(this.data[0]);
    }

    headers.forEach((header) => {
      const th = document.createElement("th");
      th.textContent = header.charAt(0).toUpperCase() + header.slice(1); // Capitalize headers
      th.classList.add("text-center"); // Center align the headers
      headersRow.appendChild(th);
    });
    thead.appendChild(headersRow);
    table.appendChild(thead);

    // Create table body
    const tbody = document.createElement("tbody");

    if (this.data.length == 0) {
      const tr = document.createElement("tr");
      const td = document.createElement("td");
      td.textContent = "No records found";
      td.classList.add("text-center");
      td.setAttribute("colspan", this.defaultHeader.length);
      tr.appendChild(td);
      tbody.appendChild(tr);
    } else {
      // Get the data for the current page
      const startIndex = (this.currentPage - 1) * this.rowsPerPage;
      const endIndex = Math.min(
        startIndex + this.rowsPerPage,
        this.data.length
      );
      const currentPageData = this.data.slice(startIndex, endIndex);

      // Create rows for the current page data
      currentPageData.forEach((rowData) => {
        const tr = document.createElement("tr");
        headers.forEach((header) => {
          const td = document.createElement("td");
          td.textContent = rowData[header];
          td.classList.add("text-center"); // Center align the data
          tr.appendChild(td);
        });
      });
      tbody.appendChild(tr);
    }

    table.appendChild(tbody);

    // Append the table to the table container
    this.tableContainer.appendChild(table);
  }

  // Method to update the pagination controls
  renderPaginationControls() {
    // Clear previous pagination controls
    this.paginationContainer.innerHTML = "";
    this.paginationContainer.classList.add(
      "d-flex",
      "justify-content-center",
      "mt-3"
    ); // Center pagination

    // Create Bootstrap pagination
    const pagination = document.createElement("ul");
    pagination.classList.add("pagination");

    // Previous button
    const prevItem = document.createElement("li");
    prevItem.classList.add("page-item");
    if (this.currentPage === 1) {
      prevItem.classList.add("disabled");
    }
    const prevLink = document.createElement("a");
    prevLink.classList.add("page-link");
    prevLink.textContent = "Previous";
    prevLink.href = "#";
    prevLink.addEventListener("click", (e) => {
      e.preventDefault();
      if (this.currentPage > 1) {
        this.currentPage--;
        this.update();
      }
    });
    prevItem.appendChild(prevLink);
    pagination.appendChild(prevItem);

    // Page numbers
    for (let i = 1; i <= this.totalPages; i++) {
      const pageItem = document.createElement("li");
      pageItem.classList.add("page-item"); // Always add the 'page-item' class

      if (this.currentPage === i) {
        pageItem.classList.add("active"); // Add 'active' only if currentPage is equal to i
      }

      const pageLink = document.createElement("a");
      pageLink.classList.add("page-link");
      pageLink.textContent = i;
      pageLink.href = "#";
      pageLink.addEventListener("click", (e) => {
        e.preventDefault();
        this.currentPage = i;
        this.update();
      });

      pageItem.appendChild(pageLink);
      pagination.appendChild(pageItem);
    }

    // Next button
    const nextItem = document.createElement("li");
    nextItem.classList.add("page-item"); // Always add the 'page-item' class
    if (this.currentPage === this.totalPages) {
      nextItem.classList.add("disabled"); // Add 'active' only if currentPage is equal to i
    }

    const nextLink = document.createElement("a");
    nextLink.classList.add("page-link");
    nextLink.textContent = "Next";
    nextLink.href = "#";
    nextLink.addEventListener("click", (e) => {
      e.preventDefault();
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.update();
      }
    });
    nextItem.appendChild(nextLink);
    pagination.appendChild(nextItem);

    // Append pagination controls to the pagination container
    this.paginationContainer.appendChild(pagination);
  }

  // Method to update the table and pagination controls when page changes
  update() {
    this.renderTable();
    if (this.data.length !== 0) {
      this.renderPaginationControls();
    }
  }

  // Method to initialize and display the table with pagination
  render(targetElement) {
    // Render initial table and pagination controls
    this.update();

    // Append the table and pagination to the target element
    targetElement.appendChild(this.tableContainer);
    targetElement.appendChild(this.paginationContainer);
  }
}

export default TableMixin;
