<?php

use PHPUnit\Framework\TestCase;
use Twitter\Model\TweetModel;

class TweetControllerTest extends TestCase
{
    /**@test */
    public function test_user_save_a_tweet_in_bdd()
    {
        //Connexion à la base de données 
        $pdo = new PDO('mysql:host=localhost;dbname=tdd_test;charset=utf8', 'tdd_test', 'tdd_test', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        //Supprimer la base de données
        $pdo->query("DELETE FROM tweets");

        $_POST['author'] = 'Younes';
        $_POST['content'] = 'Mon premier tweet';

        $model = new TweetModel($pdo);

        $tweet = new \Twitter\Controller\TweetController($model);
        $response = $tweet->store();

        // Vérification du code status
        $this->assertEquals(302, $response->getStatus());

        // Vérification de la redirection
        $this->assertArrayHasKey('location', $response->getHeaders());
        $this->assertEquals('/', $response->getHeaders()['location']);

        // Vérification de la base de données
        $result = $pdo->query('SELECT * FROM tweets AS t');
        $this->assertEquals(1, $result->rowCount());

        //Vérification de author et content
        $data = $result->fetch();
        $this->assertEquals('Younes', $data['author']);
        $this->assertEquals('Mon premier tweet', $data['content']);
    }
}
