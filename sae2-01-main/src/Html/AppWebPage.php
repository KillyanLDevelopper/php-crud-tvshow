<?php

declare(strict_types=1);

namespace Html;

require_once 'WebPage.php';

class AppWebPage extends WebPage
{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    public function toHTML(): string
    {
        /*
        $html = "<!DOCTYPE html>\n";
        $html .= "<html lang=\"fr\">\n";
        $html .= "<head>\n";
        $html .= $this->getHead();
        $html .= "<title>" . $this->getTitle() . "</title>\n";
        $html .= "</head>\n";
        $html .= "<body>\n";
        $html .= $this->getBody();
        $html .= "</body>\n";
        $html .= "</html>";
        return $html;
        */
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
                <header class="header">
                <h1>{$this->getTitle()}</h1>
                </header>
                <section class="content">
                    {$this->getBody()}
                </section>
                <section class="footer">
                {$this->getLastModification()}
                </section>
            </body>
            </html>
            HTML;

    }
}
