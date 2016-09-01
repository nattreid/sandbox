# Webové stránky s administrací

## Instalace
Nainstalujte [Composer](http://doc.nette.org/composer) a poté spusťte příkaz pro vytvoření projektu 
```bash
composer create-project nattreid/netta --repository-url=https://packages.newtravel.cz
```

Je třeba mít nainstalované balíčky **npm** a **node.js**
```bash
sudo apt-get install nodejs npm
```

a **bower**
```bash
sudo npm install -g bower
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

## Vývoj
### Nastavení
Nastavení **config.local.neon**
```neon
extensions:
    fakeSession: Kdyby\FakeSession\DI\FakeSessionExtension  # Vypnuti session

services:
    cssMin: App\Core\WebLoader\FakeMinimalizer              # Vypne minimalizaci css
    jsMin: App\Core\WebLoader\FakeMinimalizer               # Vypne minimalizaci js
    cacheStorage:
        class: Nette\Caching\Storages\DevNullStorage        # Vypne ukladani cache
