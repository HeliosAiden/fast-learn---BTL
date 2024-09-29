class HttpMixin {
  constructor(baseURL) {
      this.baseURL = baseURL;
      this.token = localStorage.getItem('jwtToken');  // Store JWT token in localStorage
  }

  // Private method to handle HTTP requests
  async _request(method, endpoint, body = null) {
      const headers = {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${this.token}`  // Add JWT token to request headers
      };

      const options = {
          method,
          headers
      };

      if (body) {
          options.body = JSON.stringify(body);
      }

      try {
          const response = await fetch(`${this.baseURL}/${endpoint}`, options);
          const data = await response.json();

          return data;
      } catch (error) {
          console.error(`HTTP ${method} Error:`, error.message);
          throw error;
      }
  }

  // GET method
  async getMixin(endpoint) {
      return await this._request('GET', endpoint);
  }

  // POST method
  async postMixin(endpoint, body) {
      return this._request('POST', endpoint, body);
  }

  // PUT method
  async putMixin(endpoint, body) {
      return this._request('PUT', endpoint, body);
  }

  // PATCH method
  async patchMixin(endpoint, body) {
      return this._request('PATCH', endpoint, body);
  }

  // DELETE method
  async deleteMixin(endpoint) {
      return this._request('DELETE', endpoint);
  }
}

export default HttpMixin;
