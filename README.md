# LAP
## Setup
### XAMPP
- XAMPP installieren (https://www.apachefriends.org/de/download.html)
- Nur Apache und MySQL benötigt
### MySQLWorkbench
- Workbench installieren (https://dev.mysql.com/downloads/workbench/)
### Visual Studio Code
- Visual Studio Code installieren (https://code.visualstudio.com/Download)
#### Extensions
- PHP (https://marketplace.visualstudio.com/items?itemName=DEVSENSE.phptools-vscode) - All-in-One PHP support - IntelliSense, Debug, Formatter, Code Lenses, Code Fixes, Linting, Refactoring, PHPUnit Tests, Web Server, and more.
- (optional) HTML CSS Support (https://marketplace.visualstudio.com/items?itemName=ecmel.vscode-html-css) - CSS Intellisense for HTML
- (optional) Live Server (https://marketplace.visualstudio.com/items?itemName=ritwickdey.LiveServer) - Launch a development local Server with live reload feature for static & dynamic pages
###### Live Server
- Live Server Web Extension (Chrome) (https://chromewebstore.google.com/detail/live-server-web-extension/fiegdmejfepffgpnejdinekhfieaogmj)
- ![image](https://github.com/soosbi1/LAP/assets/104227654/93bf9280-7b36-4ceb-b16c-215579e5d629)
- Proxy Setup - settings.json für das Projekt in Visual Studio, um den Proxy zu konfigurieren:
```
{
    "liveServer.settings.useWebExt": true,
    "liveServer.settings.proxy": {
        "enable": true,
        "baseUri": "/",
        "proxyUri": "http://127.0.0.1/WorkspaceFolderName/"
    }
}
```
### Projekt anlegen
- Das Projekt sollte in C:\xampp\htdocs angelegt werden, sofern der Speicherort in der Apache-Config nicht geändert wurde

### Praxis
- Praxis im Repository

### Ausarbeitung
- Begründen warum man z.B. Bootstrap benutzt (hat)
- Evtl. Dokumentation der praktischen Ausarbeitung
