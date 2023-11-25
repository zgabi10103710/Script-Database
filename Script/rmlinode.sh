#!/bin/bash
apt install jq -y


# Votre Token d'Accès Personnel Linode

TOKEN=$1


# Obtenir la liste des Linodes
linodes=$(curl -H "Authorization: Bearer $TOKEN" \
               https://api.linode.com/v4/linode/instances | jq '.data[].id')

# Supprimer chaque Linode
for id in $linodes
do
    echo "Suppression du Linode avec l'ID: $id"
    curl -X DELETE -H "Authorization: Bearer $TOKEN" \
         https://api.linode.com/v4/linode/instances/$id
done

echo "Tous les Linodes ont été supprimés."

