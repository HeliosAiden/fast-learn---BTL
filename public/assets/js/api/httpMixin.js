class HttpMixin {
  constructor(baseURL) {
    this.baseURL = baseURL;
    this.token = localStorage.getItem("jwtToken")
    this.inactivityTimeout = null; // To track inactivity timeout
    this.inactivityLimit = 5 * 60 * 1000; // 5 minutes (in milliseconds)
  }

  // Private method to handle HTTP requests
  async _request(method, endpoint, body = null) {

    const headers = {
      "Content-Type": "application/json",
      Authorization: `Bearer ${this.token}`, // Add JWT token to request headers
    };

    const options = {
      method,
      headers,
    };

    if (body) {
      options.body = JSON.stringify(body);
    }

    try {
      const response = await fetch(`${this.baseURL}/${endpoint}`, options);
      return await response.json();
    } catch (error) {
      console.error(
        `HTTP ${method} Error:`,
        error.message ?? "Something went wrong"
      );
      throw error;
    }
  }

  // GET method
  async getMixin(endpoint) {
    return await this._request("GET", endpoint);
  }

  // POST method
  async postMixin(endpoint, body) {
    return this._request("POST", endpoint, body);
  }

  // PUT method
  async putMixin(endpoint, body) {
    return this._request("PUT", endpoint, body);
  }

  // PATCH method
  async patchMixin(endpoint, body) {
    return this._request("PATCH", endpoint, body);
  }

  // DELETE method
  async deleteMixin(endpoint) {
    return this._request("DELETE", endpoint);
  }

  setJwtCookie(token) {
    const expiryDays = 1; // Cookie expiration time in days
    const date = new Date();
    date.setTime(date.getTime() + expiryDays * 24 * 60 * 60 * 1000); // Set expiry to 1 day later
    const expires = "expires=" + date.toUTCString();

    // Set the cookie with the JWT token
    // When using HTTPS then use Secure option
    // document.cookie = "jwtToken=" + token + ";" + expires + ";path=/;SameSite=Strict;Secure";
    document.cookie =
      "jwtToken=" + token + ";" + expires + ";path=/;SameSite=Strict";
  }

}

export default HttpMixin;
