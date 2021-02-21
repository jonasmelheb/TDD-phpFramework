<?php

namespace Twitter\Controller;

use PDO;
use Twitter\Http\Response;
use Twitter\Model\TweetModel;

class TweetController
{
    protected TweetModel $model;

    public function __construct(TweetModel $model)
    {
        $this->model = $model;
    }

    public function store(): Response
    {
        $this->model->save($_POST['author'], $_POST['content']);

        return new Response('', 302, [
            "location" => "/"
        ]);
    }
}
