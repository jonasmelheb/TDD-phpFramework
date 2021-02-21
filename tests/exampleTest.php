<?php

use PHPUnit\Framework\TestCase;

class exampleTest extends TestCase {

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
}