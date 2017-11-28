# Webové stránky s administrací (sandbox)

## Instalace
Je třeba mít nainstalované balíčky **npm** a **node.js**
```bash
sudo apt-get install nodejs npm
```

Nainstalujeme **bower** a **gulp**
```bash
sudo npm install -g bower gulp
```

A poté stačí jen spustit **bin/install.sh**

anebo můžete manuálně stáhnout [Composer](http://doc.nette.org/composer) a poté spustit následující
```bash
composer create-project nattreid/sandbox
cd nazevProjektu
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
    cssMin: WebLoader\Nette\FakeMinimalizer              # Vypne minimalizaci css
    jsMin: WebLoader\Nette\FakeMinimalizer               # Vypne minimalizaci js
    cacheStorage:
        class: Nette\Caching\Storages\DevNullStorage        # Vypne ukladani cache
```
