# projet-11-y-a-faim-back

GitHub

Pour demain si commencement projet, utilisation de Github en équipe :



								-Mise en place du projet-

echo "# projet-11-y-a-faim-back" >> README.md
```git init```

```git add README.md```

```git commit -m "first commit"```

```git branch -M main```

```git remote add origin git@github.com:O-clock-Newton/projet-11-y-a-faim-back.git```

```git push -u origin main```

main = branche de prod

dev branch = branche de préprod

(feature) branch = branche de prod d'une fonctionnalité

NE JAMAIS travailler sur la branche main et ne pas intégrer le code avant d'avoir testé les fonctionnalités.


	

								-Création d'une feature-

Lors du souhait de la création d'une nouvelle fonctionnalité sur le site:

```git checkout dev```= basculement sur la branche de dev(pour s'assurer de bien être sur la bonne branche = git branch)

```git pull``` = récupération d'éventuelles modification sur la branche dev distante, pour être à jour avec tout le monde

```git checkout -b nom fonctionnalité/page modifié(ex = feature/home)``` = création de la nouvelle branche, 

- commits régulier concis et clair (```git commit -m ex="home block header done"```)

- push des fois(pour premier push = ```git push -u origin feature/home```). 
 
 
 

								-Pull Request et Merge sur dev-

Une fois le travail finit se rendre sur Github :

Clique sur pull request

Selection de la branche sur laquelle appliquer la feature (dev) et vérification que la deuxième branche sélectionnée est celle de la feature (feature/home).

Clique sur create pull request

Une fois finit, reprendre à partir de  "Création d'une feature"

Si quelqu'un dans l'équipe vient de merge à n'importe quel moment de la journée :

Commit sur la branche Feature/... sur laquelle tu travailles

```git checkout dev``` => basculer sur la branche dev

```git pull``` => récupérer les dernières modifications depuis dev

```git checkout feature/...``` => rebasculer sur ta branche

```git merge dev``` => récupérer le travail de dev et le mettre sur ta feature

Vérifier que tout fonctionne bien, sinon résoudre les conflits en allant manuellement dans les fichiers indiqués par le terminal et accepter les modifications entrantes ou sortante en fonction de ce qui est bon ou pas.
