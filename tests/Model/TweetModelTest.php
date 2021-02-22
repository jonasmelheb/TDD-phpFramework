<?php

use Twitter\Model\TweetModel;
use PHPUnit\Framework\TestCase;

class TweetModelTest extends TestCase
{
    /**@test */
    public function test_model_save_a_tweet()
    {
        //Connexion à la base de données 
        $pdo = new PDO('mysql:host=localhost;dbname=tdd_test;charset=utf8', 'tdd_test', 'tdd_test', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        //Supprimer la base de données
        $pdo->query("DELETE FROM tweets");

        $author = 'Younes';
        $content = 'tester le ytweet';

        $model = new TweetModel($pdo);
        $newIdTweet = $model->save($author, $content);

        $this->assertNull($newIdTweet);

        // $tweet = $pdo->query("SELECT * FROM tweets WHERE id = " . $newIdTweet)->fetch();

        // $this->assertFalse($tweet);
        // $this->assertEquals($author, $tweet['author']);
    }
}
