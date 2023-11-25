<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Localhost Directory</title>
    <style>*{padding:0;margin:0;}</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>

    <h1>Depot de Script</h1>
    <table cellspacing="0" class="table">
        <tbody>
            <tr>
                <td class="head">Filename</td>
                <td class="head">Type</td>
                <td class="head">Size</td>
                <td class="head">Download</td>
            </tr>

    <?php
    function listFiles($directory, $indent = 0)
    {
        if (is_dir($directory)) {
            if ($dh = opendir($directory)) {
                while (($file = readdir($dh)) !== false) {
                    $filePath = $directory . '/' . $file;

                    if ($file != "." && $file != ".." && $file != ".git") {
                        $fileType = is_dir($filePath) ? 'Folder' : pathinfo($filePath, PATHINFO_EXTENSION);
                        $fileSize = is_dir($filePath) ? '-' : filesize($filePath) . ' bytes';
                        $relativePath = str_replace(__DIR__ . '/', '', $filePath);

                        echo '<tr>';
                        echo '<td>';

                        if (is_dir($filePath)) {
                            echo str_repeat('&nbsp;', $indent * 2);
                            echo '<span class="folder-name">' . $file . '</span>';
                            echo '<div class="folder-contents">';
                            echo '<table class="sub-table"><tbody>';
                            listFiles($filePath, $indent + 1);
                            echo '</tbody></table>';
                            echo '</div>';
                        } else {
                            echo str_repeat('&nbsp;', $indent * 2);
                            echo '<span class="' . ($fileType === 'Folder' ? 'folder' : 'file') . '">' . $file . '</span>';
                        }

                        echo '</td>';
                        echo '<td>' . $fileType . '</td>';
                        echo '<td>' . $fileSize . '</td>';
                        echo '<td>';

                        if (!is_dir($filePath)) {
                            echo '<a href="' . $relativePath . '" download>Download</a>';
                        }

                        echo '</td>';
                        echo '</tr>';
                    }
                }
                closedir($dh);
            }
        }
    }

    $directory = __DIR__ . '/Script';
    listFiles($directory);
    ?>
        </tbody>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var folderNames = document.querySelectorAll('.folder-name');

            folderNames.forEach(function (folderName) {
                folderName.addEventListener('click', function () {
                    var folderContents = this.nextElementSibling;

                    if (folderContents) {
                        if (folderContents.classList.contains('folder-contents-visible')) {
                            folderContents.classList.remove('folder-contents-visible');
                        } else {
                            folderContents.classList.add('folder-contents-visible');
                        }
                    }
                });

                // Ajoutez le code suivant pour rendre visible le contenu des dossiers par défaut
                var folderContents = folderName.nextElementSibling;
                if (folderContents) {
                    folderContents.classList.add('folder-contents-visible');
                }
            });
        });
    </script>

</body>

</html>
