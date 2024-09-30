class HttpMixin {
  constructor(baseURL) {
    this.baseURL = baseURL;
    this.token = this.setJwtToken()
    this.inactivityTimeout = null; // To track inactivity timeout
    this.inactivityLimit = 5 * 60 * 1000; // 5 minutes (in milliseconds)
    this.logoutUrl = this.baseURL + "/dang-nhap";
    this.refreshTokenEndpoint = '/app/apis/refresh_token.php'
  }

  // Private method to handle HTTP requests
  async _request(method, endpoint, body = null) {
    this.resetInactivityTimer();

    if (endpoint !== this.refreshTokenEndpoint) {
      this.refreshToken()
    }

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
      const data = await response.json();

      return data;
    } catch (error) {
      console.error(`HTTP ${method} Error:`, error.message ?? 'Something went wrong');
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

  async refreshToken() {
    const token = await this.postMixin(this.refreshTokenEndpoint, null)
    this.setJwtCookie(token)
    this.setJwtToken()
  }

  setJwtToken() {
    this.token = localStorage.getItem("jwtToken");
  }

  resetInactivityTimer() {
    // Clear the existing timeout if any
    if (this.inactivityTimeout) {
      clearTimeout(this.inactivityTimeout);
    }

    // Set a new inactivity timeout for 5 minutes
    this.inactivityTimeout = setTimeout(() => {
      this.handleLogout();
    }, this.inactivityLimit);
  }

  handleLogout() {
    this.jwtToken = ""; // Clear the JWT token (or clear session storage/local storage)
    window.location.href = this.logoutUrl; // Redirect to login page or take appropriate logout action
  }
}

export default HttpMixin;
