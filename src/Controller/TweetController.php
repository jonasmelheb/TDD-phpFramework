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
        if ($response = $this->validateFields()) {
            return  $response;
        }

        $this->model->save($_POST['author'], $_POST['content']);

        return new Response('', 302, [
            "location" => "/"
        ]);
    }

    protected function validateFields(): ?Response
    {
        $invalidField = [];

        foreach ($this->requiredFields as $field) {
            if (empty($_POST[$field])) {
                $invalidField[] = $field;
            }
        }

        if (empty($invalidField)) {
            return null;
        }

        if (count($invalidField) === 1) {
            $field = $invalidField[0];
            return new Response("Le champ $field est requis", 400);
        }

        return new Response(
            sprintf('Les champs %s sont requis', implode(' et ', $invalidField)),
            400
        );
    }
}
