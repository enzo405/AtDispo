# Documentation d'Utilisation - Ajout de Routes

Le fichier `routes.json` est l'endroit où vous configurez les routes pour votre application web à l'aide du routeur PHP. Ce guide explique comment ajouter de nouvelles routes au fichier `routes.json` pour étendre la fonctionnalité de l'application.

## Structure du Fichier `routes.json`

Le fichier `routes.json` est au format JSON et contient des informations sur les routes de l'application. Voici un exemple de sa structure :

```json
{
    "GET": [
        {
            "url": "/",
            "controllerName": "HomeController",
            "actionName": "index"
        }
    ],
    "POST": []
}
```

- `"GET"` et `"POST"` représentent les méthodes HTTP associées aux routes.
- `"url"` est l'URL correspondante à la route. Par exemple, `/mon-url`.
- `"controllerName"` est le nom du contrôleur qui gérera la requête. Assurez-vous que le contrôleur existe dans votre application.
- `"actionName"` est le nom de l'action du contrôleur à exécuter en cas de correspondance avec la route.

## Ajout de Nouvelles Routes

Pour ajouter de nouvelles routes, suivez ces étapes :

1. Ouvrez le fichier `routes.json`.
2. Trouvez le tableau associé à la méthode HTTP que vous souhaitez ajouter (par exemple, `"GET"` ou `"POST"`).
3. Ajoutez un nouvel objet JSON pour la route en respectant la structure suivante :

```json
{
    "url": "/nouvelle-route",
    "controllerName": "NouveauController",
    "actionName": "nouvelleAction"
}
```

- `"url"` : Définissez l'URL que vous souhaitez associer à la nouvelle route.
- `"controllerName"` : Spécifiez le nom du contrôleur qui gérera la requête pour cette nouvelle route.
- `"actionName"` : Indiquez le nom de l'action du contrôleur à exécuter en cas de correspondance.
- Vous avez la possibilité d'ajouter des paramètres (variables d'url) en suivant cette syntaxe `<int|str:nomParam>` avec `"str"` pour une 
variable qui peut comprendre des lettres et des chiffres, et `"int"` pour une variables qui prend seulement des chiffres (par exemple pour un id)

### Vérifiez bien :
  - Assurez-vous que le contrôleur et l'action spécifiés existent dans votre application.
  - Évitez de définir des URLs en double, car cela peut entraîner des comportements inattendus.
  - Veillez à respecter la structure JSON en utilisant des virgules pour séparer les éléments.

### Quelques exemples :

```json
{
    "GET": [
        {
            "url": "/veille/create",
            "controllerName": "VeilleController",
            "actionName": "createVeille"
        },
        {
            "url": "/veille/<int:idVeille>",
            "controllerName": "VeilleController",
            "actionName": "displayVeille"
        }
    ],
    "POST": []
}
```
