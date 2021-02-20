<?php
$books = [
    [
        "title" => "Dunia Sophie",
        "author" => "Jostein Gaarder",
        "pages" => "697",
        "publication_date" => "1991",
        "cover" => "dunia_sophie.jpg"
    ],
    [
        "title" => "Filosofi Teras",
        "author" => "Henry Manampiring",
        "pages" => "346",
        "publication_date" => "2018",
        "cover" => "filosofi_teras.jpg"
    ]
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Book</title>
</head>

<body>
    <h1>List Book</h1>
    <?php foreach ($books as $book) : ?>
        <ul>
            <li>
                <img src="img/<?php echo $book["cover"]; ?>">
            </li>
            <li>Title : <?= $book["title"]; ?></li>
            <li>Author : <?= $book["author"]; ?></li>
            <li>Pages : <?= $book["pages"]; ?></li>
            <li>Publication Date : <?= $book["publication_date"]; ?></li>
        </ul>
    <?php endforeach ?>
</body>

</html>
