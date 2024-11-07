<?php

namespace Html;

use Html\StringEscaper;

class WebPage
{
    use StringEscaper;
    private string $head;

    private string $title;

    private string $body;

    public function __construct(string $title = "")
    {
        $this->head = "";
        $this->title = $title;
        $this->body = "";

    }

    public function getHead(): string
    {
        return $this->head;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }


    public function appendContent(string $content): void
    {
        $this->body .= $content;

    }

    public function appendCss($css)
    {
        $this->head .= "<style>$css</style>";
    }

    public function appendCssUrl($url)
    {
        $this->head .= "<link rel='stylesheet' href='$url'>";
    }

    public function appendJs($js)
    {
        $this->head .= "<script>$js</script>";
    }

    public function appendJsUrl($url)
    {
        $this->head .= "<script src='$url'></script>";
    }

    public function getLastModification()
    {
        $lastModification = getlastmod();

        return date("d-m-Y H:i:s", $lastModification);
    }

    public function toHTML()
    {
        return  <<<HTML
                        <!DOCTYPE html>
                          <html lang='fr'>
                        <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>{$this->getTitle()}</title>
                        {$this->getHead()}
                        </head>
                        <body>
                        {$this->getBody()}
                        </body>
                        <footer>
                        Dernière modification le : {$this->getLastModification()}
                        </footer>
                        </html>
                        HTML;
    }


}
