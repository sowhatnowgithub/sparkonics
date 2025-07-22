// api.jsx

const BASE_URL = window.location.origin; // Replace with your actual backend URL

const BackendAPI = {
  get: async (url) => {
    const response = await fetch(`${BASE_URL}${url}`);
    if (!response.ok) {
      throw new Error(`GET ${url} failed: ${response.status}`);
    }
    return response.json();
  },

  post: async (url, data) => {
    const response = await fetch(`${BASE_URL}${url}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      throw new Error(`POST ${url} failed: ${response.status}`);
    }
    return response.json();
  },

  delete: async (url) => {
    const response = await fetch(`${BASE_URL}${url}`, {
      method: "DELETE",
    });
    if (!response.ok) {
      throw new Error(`DELETE ${url} failed: ${response.status}`);
    }
    return response.json();
  },
};

export default BackendAPI;
