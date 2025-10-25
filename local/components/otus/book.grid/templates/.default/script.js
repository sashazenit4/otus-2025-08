BX.namespace('Otus.BookGrid');

BX.Otus.BookGrid = {
    signedParams: null,
    init: function(data) {
        this.signedParams = data.signedParams;
    },
    showMessage: function (message) {
        alert(message);
    },
    deleteBook(id) {
        BX.ajax.runComponentAction('otus:book.grid', 'deleteElement', {
            mode: 'class',
            signedParameters: BX.Otus.BookGrid.signedParams,
            data: {
                bookId: id,
            },
        }).then(response => {
            BX.Otus.BookGrid.showMessage('Удалена книга с ID=' + id);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
    deleteBookViaAjax(id) {
        BX.ajax.runComponentAction('otus:book.grid', 'deleteElement', {
            mode: 'ajax',
            data: {
                bookId: id,
            },
        }).then(response => {
            BX.Otus.BookGrid.showMessage('Удалена книга с ID=' + id);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
    addTestBookElement: function () {
        BX.ajax.runComponentAction('otus:book.grid', 'addTestBookElement', {
            mode: 'class',
            signedParameters: BX.Otus.BookGrid.signedParams,
            data: {
                bookData: {
                    bookTitle: "Тестовая книга",
                    authors: [
                        1, // идентификатор автора в таблица aholin_author
                        2,
                    ],
                    publishYear: 2025,
                    pageCount: 55,
                    publishDate: '24.07.2025',
                },
            },
        }).then(response => {
            BX.Otus.BookGrid.showMessage('Создана книга с ID=' + response.data.BOOK_ID);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
    createAlternativeTestBookElement: function () {
        BX.ajax.runComponentAction('otus:book.grid', 'createTestElement', {
            mode: 'ajax',
            signedParameters: BX.Otus.BookGrid.signedParams,
            data: null,
        }).then(response => {
            BX.Otus.BookGrid.showMessage('Создана книга с ID=' + response.data.BOOK_ID);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
    createTestElementViaModule: function () {
        BX.ajax.runAction(
            'aholin:crmcustomtab.book.BookController.createTestElement',
            {}
        ).then(response => {
            BX.Otus.BookGrid.showMessage('Создана книга с ID=' + response.data.BOOK_ID);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },

    addBook: function () {
        BX.Otus.BookGrid.showForm();
    },

    showForm: function () {
        let popup = BX.PopupWindowManager.create('book-add-form', null, {
            content: '<form content="multipart/form-data" id="book-add-form"><input name="bookTitle"><input type="submit" value="Применить"></form>',
            darkMode: true,
            buttons: [
                new BX.PopupWindowButton({
                    text: "Добавить книгу" ,
                    className: "book-form-popup-window-button-accept" ,
                    events: {
                        click: function(){
                            let submit = document.querySelector('#book-add-form input[type="submit"]');
                            let form = document.getElementById('book-add-form');
                            form.addEventListener('submit', function (event) {
                                event.preventDefault();
                                BX.Otus.BookGrid.createBook(event.target);
                            });
                            submit.click();
                            this.popupWindow.close();
                        }
                    }
                }),
                new BX.PopupWindowButton({
                    text: "Закрыть" ,
                    className: "book-form-button-link-cancel" ,
                    events: {
                        click: function(){
                            this.popupWindow.close();
                        }
                    }
                })
            ]
        });
        popup.show();
    },

    createBook: function (form) {
        let data = new FormData(form);
        BX.ajax.runComponentAction('otus:book.grid', 'addBook', {
            mode: 'ajax',
            data: data,
        }).then(response => {
            let id = response.data.BOOK_ID;
            BX.Otus.BookGrid.showMessage('Добавлена книга с ID=' + id);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
}
