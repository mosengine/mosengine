
ProductPage = {

	// ID категории товара, которое должно отображаться в хлебных крошках
	PARENT_ID_HASH_PARAM_NAME: "parent_id",
	// ID UL, в котором лежат breadcrumbs
	BREADCRUMBS_CONTAINER_ID: 'breadcrumbs',

    // команды для содержимого хэша
    HASH_PARAM_HANDLERS: {
        // параметр из хэша => обработчик (имя функции из этого класса)
        add_comment: "openAddCommentPopup",
        show_comments: "scrollToComments"
    },

	/**
	 * распарсенный хэш, ключ => значение.
	 * Кроме HASH_PARAM_HANDLERS там может быть PARENT_ID_HASH_PARAM_NAME
	 */
	hash_values: {},

    init: function() {

        this.parseHash();

    },

    /**
     * Парсинг хэша из урла до загрузки страници.
     * Разделитель хэша: амперсанд (&)
     * В хэше могут быть как именованные параметры (param=value)
     * так и значения. Пример хэша:
     * #show_write_comment&parent_category=123
     */
    parseHash: function() {

        var hash = window.location.hash,
            segments,
            parts,
            i = 0,
            count;

        if (hash && hash != "#") {
            segments = hash.substr(1).split("&");
            for (i = 0, count = segments.length; i < count; i++) {
                parts = segments[i].split("=");
                this.hash_values[parts[0]] = parts[1];
            }
        }

    },

    onDocumentReady: function() {
        // Пройтись по параметрам в хэше, и если для этого параметра прописано действие - выполнить
		var action_name;
        for (action_name in this.hash_values) {
            if (action_name in this.HASH_PARAM_HANDLERS) {
                try {
                    this[this.HASH_PARAM_HANDLERS[action_name]](this.hash_values[action_name]);
                } catch (e) {
                    console.error("Ошибка действия хэша: " + action_name);
                }
            }
        }
    },

    openAddCommentPopup: function() {
        // открыть "написать отзыв"
        $('#open_add_comment_popup_button').click();
    },

    scrollToComments: function() {
        // скролить на отзывы
        $('.js-count-scroll').click();
    },

	/**
	 * заменить путь к товару в зависимости от содержимого хэша
	 * @param breadcrumbs_by_category_id
	 */
	initBreadcrumbs: function(breadcrumbs_by_category_id) {

		var parent_id = this.hash_values[this.PARENT_ID_HASH_PARAM_NAME];
		if (parent_id && (parent_id in breadcrumbs_by_category_id)) {
			document.getElementById(this.BREADCRUMBS_CONTAINER_ID).innerHTML = breadcrumbs_by_category_id[parent_id];
		}

	}

};

ProductPage.init();