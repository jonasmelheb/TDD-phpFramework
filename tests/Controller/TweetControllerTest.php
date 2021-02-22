<?php

use PHPUnit\Framework\TestCase;
use Twitter\Controller\TweetController;
use Twitter\Model\TweetModel;

class TweetControllerTest extends TestCase
{
    protected PDO $pdo;
    protected TweetModel $tweetModel;
    protected TweetController $controller;

    protected function setUp(): void
    {
        //Connexion à la base de données 
        $this->pdo = new PDO('mysql:host=localhost;dbname=tdd_test;charset=utf8', 'tdd_test', 'tdd_test', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        //Supprimer la base de données
        $this->pdo->query("DELETE FROM tweets");


        $this->tweetModel = new TweetModel($this->pdo);

        $this->controller = new \Twitter\Controller\TweetController($this->tweetModel);

        $_POST = [];
    }

    /**@test */
    public function test_user_save_a_tweet_in_bdd()
    {
        $_POST['author'] = 'Younes';
        $_POST['content'] = 'Mon premier tweet';

        $response = $this->controller->store();

        // Vérification du code status
        $this->assertEquals(302, $response->getStatus());

        // Vérification de la redirection
        $this->assertArrayHasKey('location', $response->getHeaders());
        $this->assertEquals('/', $response->getHeaders()['location']);

        // Vérification de la base de données
        $result = $this->pdo->query('SELECT * FROM tweets AS t');
        $this->assertEquals(1, $result->rowCount());

        //Vérification de author et content
        $data = $result->fetch();
        $this->assertEquals('Younes', $data['author']);
        $this->assertEquals('Mon premier tweet', $data['content']);
    }

    /**@test */
    public function test_it_cant_save_a_tweet_if_post_author_empty()
    {
        $_POST['content'] = 'tweet test';

        $response = $this->controller->store();

        // Vérification du code status
        $this->assertEquals(400, $response->getStatus());

        // Vérification du content
        $this->assertEquals('Le champ author est requis', $response->getContent());
    }

    /**@test */
    public function test_it_cant_save_a_tweet_if_post_content_empty()
    {
        $_POST['author'] = 'Younes';

        $response = $this->controller->store();

        // Vérification du code status
        $this->assertEquals(400, $response->getStatus());

        // Vérification du content
        $this->assertEquals('Le champ content est requis', $response->getContent());
    }
}
