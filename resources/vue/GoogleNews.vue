<template>
    <div id="app">
        <div class="container">
            <h2>View latest google news - {{ keyword }}</h2>

            <form @submit.prevent="searchNews" class="lead row gap-xs card card__body" role="search" style="margin-bottom: 2vh;">
                <div class="input-container full-width">
                    <svg class="no-pointer icon icon-tabler-search" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M21 21l-6 -6"></path>
                    </svg>
                    <input v-model="keyword" type="search" name="q" placeholder="Search for latest news by keyword" aria-label="Search all discussions" autofocus="">
                </div>
                <button type="submit" class="btn bg-accent">Search</button>
            </form>

            <table class="full-width" style="width: 100%">
                <thead>
                <tr>
                    <th>News</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(news, index) in filteredNews" :key="index">
                    <td>
                        {{ news.title }}
                        <br>
                        <small>
                            {{ news.timestamp }}
                        </small>
                    </td>
                    <td>
                        <a :href="news.link" target="_blank" class="btn btn-primary">Get Article</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: 'python', // Default keyword
            newsList: [
                // Add your news objects here
                // { title: '...', timestamp: '...', link: '...' },
            ],
        };
    },
    computed: {
        filteredNews() {
            // Filter news based on the keyword
            return this.newsList.filter(news => news.title.toLowerCase().includes(this.keyword.toLowerCase()));
        },
    },
    methods: {
        searchNews() {
            // You can implement the API call or update the newsList based on your data source
            // For now, let's assume you have a predefined list of news objects
            // Replace this with your actual data fetching logic

            // Example:
            // this.newsList = fetchDataFromAPI(this.keyword);

            // For the sake of simplicity, I'll provide a static list of news
            // Replace this with your actual data
            this.newsList = [
                { title: 'Example News 1', timestamp: '16-12-2023 12:00:02', link: 'http://example.com/news1' },
                { title: 'Example News 2', timestamp: '16-12-2023 12:00:00', link: 'http://example.com/news2' },
                // Add more news objects as needed
            ];
        },
    },
};
</script>

<style scoped>
.container {
    margin: 20px;
}
</style>
