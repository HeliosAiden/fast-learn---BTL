const httpMixin = {
  /**
   * Make a GET request
   * @param {string} url - The URL to send the request to
   */
  async getMixin(url) {
    return fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    }).then(this.handleResponse);
  },
  /**
   * Make a POST request
   * @param {string} url - The URL to send the request to
   * @param {Object} data - The data to send as the request body
   */
  async postMixin(url, data = {}) {
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then(this.handleResponse)
      .then((result) => {
        if (result.status === "success") {
          alert(result.message); // User registered successfully
        } else {
          alert(result.message); // Display error message
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  },

  /**
   * Make a PUT request
   * @param {string} url - The URL to send the request to
   * @param {Object} data - The data to send as the request body
   */
  async putMixin(url, data = {}) {
    return fetch(url, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    }).then(this.handleResponse);
  },

  /**
   * Make a PATCH request
   * @param {string} url - The URL to send the request to
   * @param {Object} data - The data to send as the request body
   */
  async patchMixin(url, data = {}) {
    return fetch(url, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    }).then(this.handleResponse);
  },

  /**
   * Make a DELETE request
   * @param {string} url - The URL to send the request to
   * @param {Object} data - The data to send as the request body (if any)
   */
  async deleteMixin(url, data = {}) {
    return fetch(url, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    }).then(this.handleResponse);
  },

  /**
   * Handle the response of an HTTP request
   * @param {Response} response - The response object from fetch
   * @returns {Promise<any>} - A promise that resolves to the response data or throws an error
   */
  handleResponse(response) {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  },
};

export default httpMixin;
