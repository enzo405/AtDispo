<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Voici tous les liens de validation:</h2>
            <div class="info-generale">
                <ul class="basic-ul">
                    <li>
                        <span class="stats">Vous avez <?= $statsUser ?> utilisateur(s) à valider : </span>
                        <a href="<?= SITE_ROOT ?>/admin/users/waiting">Cliquez ici pour voir les Utilisateurs en attente</a>
                    </li>
                    <li>
                        <span class="stats">Vous avez <?= $statsOrganism ?> organisme(s) à valider : </span>
                        <a href="<?= SITE_ROOT ?>/admin/organismes/waiting">Cliquez ici pour voir les Organismes en attente</a>
                    </li>
                    <li>
                        <span class="stats">Vous avez <?= $statsMatiere ?> matière(s) à valider : </span>
                        <a href="<?= SITE_ROOT ?>/admin/matieres/waiting">Cliquez ici pour voir les Matières en attente</a>
                    </li>
                    <li>
                        <span class="stats">Vous avez <?= $statsOption ?> Option(s) à valider : </span>
                        <a href="<?= SITE_ROOT ?>/admin/options/waiting">Cliquez ici pour voir les Options en attente</a>
                    </li>
                    <li>
                        <span class="stats">Vous avez <?= $statsNomsFormation ?> noms de formation(s) à valider : </span>
                        <a href="<?= SITE_ROOT ?>/admin/noms-formation/waiting">Cliquez ici pour voir les Noms de formation en attente</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>