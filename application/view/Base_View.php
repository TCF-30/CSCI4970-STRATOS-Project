<?php

class Base_View
{
	public function __construct()
	{

	}

	public function renderBody($body)
	{
        $head = '<html>
                    <head>
                        <meta charset="utf-8"/>
                        <title>PKI-STRATOS</title>
                        <link rel="stylesheet" type="text/css" href="/public/css/style.css"/>
                    </head>
                    <body>
                        <div id="header">
                            <img src="/public/imgs/Header.jpg" alt="Header" width=100% height=7%>
                        </div>
                        <div id="bottom">
                            <div id="menu">';
                            # MenuBar.php gets inserted here
        $tail =                 '<input type="text" src="/application/view/_templates/MenuBar.php">
                            </div>
                            <div id="body" class="pagebody">';
        $tail .=                $body;
        $tail .=            '</div>
                        </div>
                    </body>
                </html>';


        echo $head;
            require_once(APP . 'view\_templates\MenuBar.php');
        echo $tail;
	}
}

?>