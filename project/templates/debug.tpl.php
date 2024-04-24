<h2>Ce contenu est temporaire</h2>
<div style="display: flex; flex-direction: row;">
    <div>
        <h3>GET</h3>
        <?php foreach($routes['GET'] as $route) { 
            $routeUrl = $route['url'];
            $routeUrl = preg_replace("/<str:[\w]*>/", "1", $routeUrl);
            $routeUrl = preg_replace("/<int:[\w]*>/", "1", $routeUrl); ?>
            <a href="<?= $routeUrl ?>"><?= $route['controllerName'] . "->" . $route['actionName'] . "()" ?></a><br>
        <?php } ?>
    </div>
    <div class="field">
        <form action="<?= SITE_ROOT ?>/mailtest" method="POST">
            <input type="submit" value="send test mail">
        </form>
    </div>
</div>