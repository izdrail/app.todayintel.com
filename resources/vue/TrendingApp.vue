<template>
    <div class="container">
        <!-- Search -->
        <div class="lead row gutter card card__body" role="search">
            <div class="input-container full-width">
                <svg class="no-pointer icon icon-tabler-search"></svg>
                <input v-model="keyword" type="search" name="keyword" placeholder="Search for latest news by keyword"
                       aria-label="Search all discussions" autofocus="">
            </div>
            <a type="submit" @click="getArticles" class="btn bg-accent">Search</a>
        </div>

        <!-- Trending -->
        <div class="gap-lg">
            <a @click="getArticles(keyword.keyword)" class="badge" v-for="keyword in keywords">
                {{ keyword.keyword }} : {{ keyword.count }}
            </a>
        </div>

        <!-- Loading -->
        <div v-if="loading"  class="lead row gutter">
            <div class="spinner spinner--block" role="status" aria-label="loading"></div>
        </div>



        <!-- Select All Button -->
        <div class="row gutter" v-if="showSelectAllButton">
            <button class="btn bg-success text-right" @click="submitAll">
                Send to extractor
            </button>
        </div>

        <!-- News -->
        <div class="lead row gutter" v-if="!loading">

            <table  class="full-width">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(article, index) in articles" :key="index">
                    <td>
                        <input type="checkbox" @click="pushUrl(article.url)" name="links[]">
                    </td>
                    <td>
                        {{ article.title }}
                    </td>
                    <td>
                        <a  @click="extractArticle(article.title, article.url)" title="Extract" target="_blank">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-spider"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4v2l5 5" /><path d="M2.5 9.5l1.5 1.5h6" /><path d="M4 19v-2l6 -6" /><path d="M19 4v2l-5 5" /><path d="M21.5 9.5l-1.5 1.5h-6" /><path d="M20 19v-2l-6 -6" /><path d="M12 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M12 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>
                        </a>
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
            keyword: 'python',
            loading: true,
            articles: [],
            keywords: [],
            sortByField: '',
            sortDesc: false,
            selectedLinks: [],
            showSelectAllButton: false,
        };
    },
    methods: {
        getArticles(keyword = null) {
            this.loading = true;
            this.keyword = keyword ? keyword : this.keyword;
            fetch('/api/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*'
                },
                body: JSON.stringify({
                    keyword: this.keyword,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                })
            })
                .then(response => {
                    this.loading = false;
                    return response.json();
                })
                .then(response => {
                    console.log(response.data);
                    this.loading = false;
                    this.articles = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        extractArticle(title, url) {
            this.loading = true;
            fetch('/api/extract', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*'
                },
                body: JSON.stringify({
                    url: url,
                    title: title,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                })
            })
                .then(response => {
                    this.loading = false;
                    return response.json();
                })
                .then(response => {
                    console.log(response);
                    this.loading = false;
                    this.articles = response.articles;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getTrendingKeywords() {
            this.loading = true;
            fetch('/api/trending', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*'
                },
            })
                .then(response => {
                    this.loading = false;
                    return response.json();
                })
                .then(response => {
                    console.log(response);
                    this.keywords = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        submitAll() {
            if (this.selectedLinks.length > 0) {
                this.showSelectAllButton = true;
                fetch('/api/article/save-articles', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                    },
                    body: JSON.stringify({
                        links: this.selectedLinks,
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }),
                })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
        pushUrl(url) {
            this.showSelectAllButton = true;
            this.selectedLinks.push(btoa(url));
        },
        getKeywordColor(sentiment) {
            return 'black'; // Default color
        },
        isPositive(sentiment) {
            // Assuming sentiment is an array of sentiment values
            const highestSentiment = Math.max(...sentiment);
            return highestSentiment > 0.5;
        }
    },
    mounted() {
        this.getTrendingKeywords();
    },
};
</script>

<style scoped>
.container {
    margin: 20px;
}

.lead {
    font-size: 1.25rem;
    font-weight: 300;
    line-height: 1.5;
    margin-bottom: 5vh;
}

input {
    margin-right: 2vw;
}

.positive-link {
    /* Add your styles for positive sentiment links */
    color: green;
}

.negative-link {
    /* Add your styles for negative sentiment links */
    color: red;
}

.neutral-link {
    /* Add your styles for neutral sentiment links */
    color: blue;
}
</style>
