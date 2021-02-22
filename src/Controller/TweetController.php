<?php

namespace Twitter\Controller;

use PDO;
use Twitter\Http\Response;
use Twitter\Model\TweetModel;

class TweetController
{
    protected TweetModel $model;
    protected array $requiredFields = [
        "author", "content"
    ];

    public function __construct(TweetModel $model)
    {
        $this->model = $model;
    }

    public function store(): Response
    {
        foreach ($this->requiredFields as $field) {
            if (empty($_POST[$field])) {
                return new Response("Le champ $field est requis", 400);
            }
        }

        $this->model->save($_POST['author'], $_POST['content']);

        return new Response('', 302, [
            "location" => "/"
        ]);
    }
}
