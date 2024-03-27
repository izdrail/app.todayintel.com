// apiService.js

const hackerNews = '/api/trending/'; // Adjust the API endpoint accordingly
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
export const apiService = {
    articles(keyword) {
        return fetch(`/api/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
            },
            body: JSON.stringify({
                keyword,
                _token: csrfToken,
            }),
        })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                return response.data;
            })
            .catch(error => console.error(error));
    },

    getTrendingKeywords(csrfToken) {
        // Similar implementation as above, adjust the endpoint if needed
    },

    getTopics(keyword) {
        // Similar implementation as above, adjust the endpoint if needed
    },

    saveArticles(selectedLinks, csrfToken) {
        // Similar implementation as above, adjust the endpoint if needed
    },
};
