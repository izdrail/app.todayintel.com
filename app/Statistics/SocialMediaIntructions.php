<?php

final class SocialMediaIntructions {

    private array $facebook_statistics;
    private array $twitter_statistics;
    private array $instagram_statistics;
    private array $tiktok_statistics;
    private array $pinterest_statistics;
    private array $medium_statistics;
    public function __construct() {
        // Initialize Facebook statistics
        $this->facebook_statistics = [
            "active_users" => "Facebook has over 2.8 billion monthly active users.",
            "demographics" => [
                "age" => "Users aged 25 to 34 are the largest demographic group on Facebook.",
                "countries" => "Facebook is used in more than 190 countries."
            ],
            "engagement" => [
                "likes" => "More than 4.75 billion posts are liked on Facebook every day.",
                "shares" => "Over 1 billion posts are shared on Facebook every day.",
                "comments" => "Facebook users leave more than 10 billion comments per month."
            ],
            "advertising" => [
                "businesses" => "Over 200 million businesses use Facebook's tools for advertising.",
                "ads" => "Facebook users click on 12 ads per month on average."
            ],
            "content_types" => [
                "videos" => "Facebook videos receive an average of 8 billion views per day.",
                "live_videos" => "Facebook Live videos are watched 3 times longer than regular videos.",
                "photos" => "More than 350 million photos are uploaded to Facebook every day."
            ],
            "best_times" => [
                "weekdays" => "Best times to post on weekdays are generally mid-morning (10:00 AM - 11:00 AM) and mid-afternoon (1:00 PM - 3:00 PM).",
                "weekends" => "On weekends, it's best to post in the late morning (11:00 AM - 1:00 PM)."
            ]
        ];

        // Initialize Twitter statistics
        $this->twitter_statistics = [
            "active_users" => "Twitter has over 330 million monthly active users.",
            "demographics" => [
                "age" => "The largest age group on Twitter is between 18 to 29 years old.",
                "countries" => "Twitter is used in more than 68 countries."
            ],
            "engagement" => [
                "tweets" => "Over 500 million tweets are sent per day.",
                "retweets" => "Retweets account for 80% of Twitter's engagement.",
                "hashtags" => "Tweets with hashtags receive 2 times more engagement."
            ],
            "advertising" => [
                "businesses" => "Twitter has over 130,000 advertisers.",
                "ads" => "Promoted tweets can reach over 500 million users."
            ],
            "content_types" => [
                "videos" => "80% of Twitter users watch video content on the platform.",
                "images" => "Tweets with images receive 150% more retweets."
            ],
            "best_times" => [
                "weekdays" => "Best times to tweet on weekdays are during lunchtime (12:00 PM - 1:00 PM) and in the early evening (5:00 PM - 6:00 PM).",
                "weekends" => "On weekends, it's best to tweet in the late morning (11:00 AM - 1:00 PM)."
            ]
        ];

        // Initialize Instagram statistics
        $this->instagram_statistics = [
            "active_users" => "Instagram has over 1 billion monthly active users.",
            "demographics" => [
                "age" => "The largest age group on Instagram is between 18 to 34 years old.",
                "countries" => "Instagram is used in more than 200 countries."
            ],
            "engagement" => [
                "likes" => "Over 4.2 billion likes are given on Instagram every day.",
                "comments" => "Instagram users leave more than 500 million comments per day.",
                "stories" => "500 million users use Instagram Stories every day."
            ],
            "advertising" => [
                "businesses" => "Instagram has over 2 million monthly active advertisers.",
                "ads" => "Instagram ads can reach up to 1.16 billion users."
            ],
            "content_types" => [
                "photos" => "Photos receive 36% more engagement than videos on Instagram.",
                "videos" => "Instagram videos receive 21% more engagement than photos."
            ],
            "best_times" => [
                "weekdays" => "Best times to post on weekdays are during lunchtime (11:00 AM - 1:00 PM) and in the early evening (7:00 PM - 9:00 PM).",
                "weekends" => "On weekends, it's best to post in the late morning (10:00 AM - 12:00 PM)."
            ]
        ];

        // Initialize TikTok statistics
        $this->tiktok_statistics = [
            "active_users" => "TikTok has over 1 billion monthly active users.",
            "demographics" => [
                "age" => "The largest age group on TikTok is between 16 to 24 years old.",
                "countries" => "TikTok is used in more than 150 countries."
            ],
            "engagement" => [
                "videos" => "TikTok videos receive an average of 1 million views per day.",
                "likes" => "TikTok users give over 3 billion likes per day.",
                "comments" => "More than 2 billion comments are posted on TikTok daily."
            ],
            "content_types" => [
                "videos" => "Video content on TikTok receives the highest engagement.",
                "challenges" => "Participating in trending challenges can significantly increase visibility and engagement."
            ],
            "best_times" => [
                "weekdays" => "Best times to post on TikTok are generally in the late afternoon (3:00 PM - 5:00 PM) and in the evening (7:00 PM - 9:00 PM).",
                "weekends" => "On weekends, it's best to post in the late morning (11:00 AM - 1:00 PM) and in the early evening (5:00 PM - 7:00 PM)."
            ]
        ];

        // Initialize Pinterest statistics
        $this->pinterest_statistics = [
            "active_users" => "Pinterest has over 450 million monthly active users.",
            "demographics" => [
                "gender" => "70% of Pinterest users are female.",
                "age" => "The largest age group on Pinterest is between 18 to 49 years old."
            ],
            "engagement" => [
                "pins" => "Over 5 billion pins are saved on Pinterest every day.",
                "clicks" => "Pinterest drives 33% more referral traffic to shopping sites than Facebook.",
                "searches" => "There are over 2 billion searches performed on Pinterest every month."
            ],
            "content_types" => [
                "pins" => "Pins with images receive 20 times more engagement than those without.",
                "videos" => "Video content on Pinterest continues to grow, with a 100% increase in video views."
            ],
            "best_times" => [
                "weekdays" => "Best times to pin on weekdays are during the evening (8:00 PM - 11:00 PM).",
                "weekends" => "On weekends, it's best to pin in the afternoon (2:00 PM - 4:00 PM)."
            ]
        ];

        // Initialize Medium statistics
        $this->medium_statistics = [
            "active_users" => "Medium has over 100 million monthly active users.",
            "demographics" => [
                "age" => "The largest age group on Medium is between 25 to 34 years old.",
                "income" => "60% of Medium users have a household income of over $100,000."
            ],
            "engagement" => [
                "reads" => "Medium users read over 50 million articles per month.",
                "claps" => "Over 25 million claps (likes) are given on Medium every month.",
                "publications" => "There are over 1 million publications on Medium."
            ],
            "content_types" => [
                "articles" => "Long-form articles perform well on Medium, with an average reading time of 7 minutes.",
                "stories" => "Personal stories and narratives are popular on Medium."
            ],
            "best_times" => [
                "weekdays" => "Best times to publish on Medium are during the morning (9:00 AM - 11:00 AM) and in the early evening (5:00 PM - 7:00 PM).",
                "weekends" => "On weekends, it's best to publish in the late morning (11:00 AM - 1:00 PM)."
            ]
        ];
    }

    public function getFacebookStatistics() {
        return $this->facebook_statistics;
    }

    public function getTwitterStatistics() {
        return $this->twitter_statistics;
    }

    public function getInstagramStatistics() {
        return $this->instagram_statistics;
    }

    public function getTikTokStatistics() {
        return $this->tiktok_statistics;
    }

    public function getPinterestStatistics() {
        return $this->pinterest_statistics;
    }

    public function getMediumStatistics() {
        return $this->medium_statistics;
    }

}

// Example usage
