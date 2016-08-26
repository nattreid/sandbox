# Webové stránky s administrací

## Instalace
Nainstalujte [Composer](http://doc.nette.org/composer) a poté spusťte příkaz pro vytvoření projektu 
```bash
composer create-project nattreid/netta --repository-url=git@git.newtravel.cz:nattreid/netta.git
```

Je třeba mít nainstalované balíčky **npm** a **node.js**
```bash
sudo apt-get install nodejs npm
```

a **bower**
```bash
npm install -g bower
```

Poté jděte do složky s projektem
```bash
cd nazevProjektu
```

a spusťte
```bash
npm install
bower install
gulp
```