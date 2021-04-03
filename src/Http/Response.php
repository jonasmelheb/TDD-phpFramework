<?php

namespace Twitter\Http;

class Response {

    protected string $content = '';

    protected array $headers = [];

    protected int $status = 200;

    /**
     * Undocumented function
     *
     * @param array $headers
     * @param integer $status
     * @param string $content
     */
    public function __construct(string $content = '',  int $status = 200 ,array $headers = ['Content-Type' => 'text/html'])
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * Get Content
     *
     * @return void
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param [string] $content
     * @return string
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Get status
     *
     * @return void
     */
    public function getStatus(): int 
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param int $status
     * @return int
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get headers
     *
     * @return void
     */
    public function getHeaders(): array 
    {
        return $this->headers;
    }

    /**
     * Set headers
     *
     * @param array $headers
     * @return array
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function send()
    {
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        http_response_code($this->status);

        echo $this->content;
    }
}
