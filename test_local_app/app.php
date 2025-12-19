<?php
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Добавление книги</title>
    <script src="//api.bitrix24.com/api/v1/"></script>
</head>
<body>
<form id="BOOK_ADD_FORM">
    <input type="text" name="title" value="КНИГА">
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('BOOK_ADD_FORM');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const bookTitle = document.querySelector('input[name="title"]')?.value;
            BX24.callMethod('otus.book.add', {
                'BOOK': {
                    'TITLE': bookTitle,
                }
            }, function (response) {

            });
        })
    });
</script>
</body>
</html>
