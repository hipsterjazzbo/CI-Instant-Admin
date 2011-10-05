<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Lumix Rewards</title>
        <meta name="description" content="">
        <meta name="author" content="http://www.wasabi.co">

        <script src="<?= site_url('js/jquery-1.5.2.min.js') ?>"></script>

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

        <script src="<?= base_url('js/libs/modernizr-2.0.6.min.js') ?>"></script>
    </head>
    <body id="<?= $page ?>">

        <div id="container">
            <header id="header">
                <nav id="main-menu">
                    <ul>
                        <li><a href="/page/home">Home</a></li>
                        <li><a href="/page/contest_1">The Contest in 1-2-3</a></li>
                        <li><a href="/page/prizes_1">Prizes</a></li>
                        <li><a href="/page/check_score_graph">Check Your Score</a></li>
                        <li id="record-sales-button"><a href="/page/record_sales">Record Sales</a></li>
                        <li><a href="/page/terms_and_conditions">Terms &amp; Conditions</a></li>
                        <li><a href="/page/faq">FAQ's</a></li>
                    </ul>
                </nav>

                <nav id="secondary-menu">
                    <ul>
                        <li><a target="_blank" href="http://www.panasonic.co.nz">www.panasonic.co.nz</a></li>
                        <li><a href="/admin/auth/logout">logout</a></li>
                    </ul>
                </nav>
            </header>

            <section id="main" role="main">
                <div id="left">
                    <?php $this->load->view($page . '_left'); ?>
                </div>

                <div id="right">
                    <?php $this->load->view($page . '_right'); ?>
                </div>
            </section>

            <footer id="footer">
                <p>&copy; 2011, Indigo Direct Communications Ltd. All rights reserved.</p>
            </footer>
        </div> <!--! end of #container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?= base_url('js/libs/jquery-1.6.2.min.js') ?>"><\/script>')</script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']]; // Change UA-XXXXX-X to be your site's ID
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
                g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
                s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

        <!--[if lt IE 7 ]>
                <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
                <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
        <![endif]-->

    </body>
</html>