# Le site de la kfet de l'ENSIM !

Bien que pas incroyable, voici le site de notre chère Kfet qui nous permet de payer directement sans devoir faire des
Lydia toutes les 7 secondes.

Ce site a été réalisé par :
- Tom de Pasquale • _Développement, design, base de donnée et serveur_
- Aksel Vaillant • _Développement et design_
- Maël Pénicaud • _Tests et gestion du serveur_
- Numa Gallipot • _Infographie_

# Mise à jour du site

Pour mettre à jour le site une fois les modifications effectuées et push sur Github, il faut clone le repository et
modifier les permissions :

```bash
sudo chown -R www-data kfet-lemans/
sudo chmod -R 777 kfet-lemans/
```

# Plugins et *toolkits* utilisés

- [Bootstrap v4.5.2](https://getbootstrap.com/)
- [Fast table filter v26.11.2018](https://www.jqueryscript.net/table/fast-table-filter.html)
- [Iconic](https://useiconic.com/open)
- [jQuery v3.5.1](https://jquery.com/)
- [Popper v1.16](https://popper.js.org/)
- [Sort Element v0.11](https://github.com/padolsey-archive/jquery.fn/tree/master/sortElements)
- [Validation v1.19.3](https://jqueryvalidation.org/)
- [X-editable v1.5.3](https://github.com/vitalets/x-editable)
- [X-editable-file v1.0](https://github.com/SUKOHI/x-editable-file)

### Note :
X-editable fonctionne correctement avec bootstrap-4. Le plugin X-editable-file a été modifié pour fonctionner lui aussi 
avec bootstrap-4.
