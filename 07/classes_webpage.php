<?php

class WebPage {
    public string $title;

    public function __construct(string $title = "") 
    {
        $this->title = $title;
    }

    public function showHeader()
    {
        echo "<!DOCTYPE html>\n";
        echo "<head>\n";
        echo "  <title>" . htmlspecialchars($this->title) . "</title>\n";
        echo "</head>\n";
        echo "<body>\n";
    }  

    public function showContent(string $content)
    {
        echo "  <main>" . $content . "</main>\n";
    }   

    public function showFooter()
    {
        echo "  <footer>\n";
        echo "    <p> Pagina is gemaakt op " . date('d-m-Y'). "</p>\n";
        echo "  </footer>\n";
        echo "</body>\n";
        echo "</html>\n";
    }
}