// assets/js/ajaxHelper.js

/**
 * Perform an AJAX request using Fetch API.
 * @param {Object} options - The AJAX options.
 * @param {string} options.url - The request URL.
 * @param {string} [options.method=GET] - The HTTP method (GET, POST, etc.).
 * @param {Object} [options.data=null] - The data to send with the request.
 * @returns {Promise} - Resolves with the JSON response or rejects with an error.
 */
export async function ajaxRequest({ url, method = 'GET', data = null }) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    };

    if (data && method.toUpperCase() !== 'GET') {
        options.body = new URLSearchParams(data).toString();
    } else if (data) {
        const queryString = new URLSearchParams(data).toString();
        url += `?${queryString}`;
    }

    try {
        const response = await fetch(url, options);

        // Handle non-JSON or empty responses
        const text = await response.text();
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status} - ${text}`);
        }

        try {
            return JSON.parse(text); // Validate JSON response
        } catch (jsonError) {
            throw new Error('Invalid JSON response: ' + text);
        }
    } catch (error) {
        console.error('Error in ajaxRequest:', error.message);
        throw error;
    }
}


console.log("ajaxHelper.js loaded successfully.");
