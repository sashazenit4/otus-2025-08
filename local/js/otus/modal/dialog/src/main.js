BX.namespace('Otus.Modal.Dialog');

BX.Otus.Modal.Dialog = {
    popupId: null,
    caption: null,
    content: null,
    htmlContent: null,
    actionYes: null,
    actionNo: null,
    actionYesCaption: null,
    actionNoCaption: null,
    popup: {},
    init: function (data) {
        this.popupId = data.popupId;
        this.caption = data.caption;
        this.content = data.content;
        this.htmlContent = data.htmlContent;
        this.actionYes = data.actionYes;
        this.actionNo = data.actionNo;
        this.actionYesCaption = data.actionYesCaption;
        this.actionNoCaption = data.actionNoCaption;
    },
    createPopup: function () {
        let content = null !== this.content ?
            '<div class="otus-popup__content-default">' + this.content + '</div>' :
            this.htmlContent;

        this.popup = new BX.PopupWindow(this.popupId, window.body, {
            zIndex: 1,
            offsetLeft: 0,
            offsetTop: 0,
            draggable: {restrict: false},
            overlay: {backgroundColor: 'black', opacity: '80' },
            titleBar: {
                content: this.caption,
            },
            buttons: [
                new BX.PopupWindowButton({
                    text: this.actionYesCaption,
                    className: "popup-window-button-accept",
                    events: {
                        click: this.actionYes,
                    }
                }),
                new BX.PopupWindowButton({
                    text: this.actionNoCaption,
                    className: "webform-button-link-cancel",
                    events: {
                        click: this.actionNo,
                    }
                }),
            ],
        });
        this.popup.setContent(content);
        this.popup.setTitleBar(this.caption);
    },
    openPopup: function () {
        this.popup.show();
    },
    closePopup: function () {
        this.popup.close();
    }
};
