<h2 class="h2AValider">Liste des utilisateurs</h2>
<div class="contenuListeAValider grid-5">
    <h3>Nom</h3>
    <h3>Prénom</h3>
    <h3>Courriel</h3>
    <h3>Role</h3>
    <h3>Action</h3>
    <?php if (count($userList) == 0) { ?>
        <p>Aucun utilisateur n'est présent dans la base de donnée</p>
    <?php } else { ?>
    <?php foreach($userList as $user){ ?>
        <p><?= $user->nom ?></p>
        <p><?= $user->prenom ?></p>
        <p><?= $user->courriel ?></p>
        <p><?php
            foreach($user->roles as $role){
                echo $role->libelleTypeCompte . "<br>";
            }
        ?></p>
        <p>
            <span class="link-button"><a href="<?= SITE_ROOT ?>/admin/users/<?= $user->id ?>">Voir le profil</a></span>
        </p>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/users?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>