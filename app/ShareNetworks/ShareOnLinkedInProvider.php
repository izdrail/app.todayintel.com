<?php
declare(strict_types=1);
namespace App\ShareNetworks;



use App\Contracts\Social\ShareContract;
use App\Data\DTO\AccountDTO;
use App\Data\Models\Post;
use GuzzleHttp\ClientInterface;

class ShareOnLinkedInProvider extends ShareAgent implements ShareContract
{

    public function __construct(private ClientInterface $client)
    {
    }

    final public function share(Post $post, AccountDTO $accountDTO): string
    {

        $linkedinAccessToken = $post->account()->get()->first();
        $linkedInID = $linkedinAccessToken['data']['id'];
        $data = [
            "author" => 'urn:li:person:' . $linkedInID,
            "lifecycleState" => "PUBLISHED",
            "specificContent" => [
                "com.linkedin.ugc.ShareContent" => [
                    "shareCommentary" => [
                        "text" => $post->body
                    ],
                    "shareMediaCategory" => "ARTICLE",
                    "media" => [
                        [
                            "status" => "READY",
                            "description" => [
                                "text" => "Try our free AI tool that can help you create content for your social media posts."
                            ],
                            "originalUrl" => "https://lzomedia.com/",
                            "title" => [
                                "text" => "Free AI Tool."
                            ]
                        ],
                    ]
                ]
            ],
            "visibility" => [
                "com.linkedin.ugc.MemberNetworkVisibility" => "PUBLIC"
            ]
        ];

        //echo json_encode($data, JSON_PRETTY_PRINT);


        $response = $this->client->post('https://api.linkedin.com/v2/ugcPosts', [
            'headers' => [
                'Authorization' => 'Bearer ' . $linkedinAccessToken->access_token,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        if ($response->getStatusCode() == 201) {
            return "Post on LinkedIn successful!";
        } else {
            return "Error posting on LinkedIn: " . $response->getBody()->getContents();
        }
    }
}
