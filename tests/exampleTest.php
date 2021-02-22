<?php

use PHPUnit\Framework\TestCase;
use Twitter\Controller\HelloController;

class exampleTest extends TestCase
{

    /**@test */
    public function test_homepage_says_hello()
    {
        $_GET['name'] = 'Younes';

        $controller = new \Twitter\Controller\HelloController;
        $response = $controller->hello();

        $this->assertEquals("Hello Younes", $response->getContent());

        $this->assertEquals(200, $response->getStatus());

        $response = $response->getHeaders()['Content-Type'];
        $this->assertEquals('text/html', $response);
    }

    /**@test */
    public function test_homepage_says_hello_everyone_if_no_name_in_Get()
    {
        $_GET = [];

        $controller = new HelloController;
        $response = $controller->hello();

        $this->assertEquals("Hello tout le monde", $response->getContent());
    }
}
