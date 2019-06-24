$.overridePlugin('swAjaxVariant', {
    defaults: {
        productDetailsSelector: '.product--detail-upper',
        productBundlePanel: '.product--title',
        productBundlePanelNew: '.custom-attr-bc',
        configuratorFormSelector: '.configurator--form',
        orderNumberSelector: '.entry--sku .entry--content',
        historyIdentifier: 'sw-ajax-variants',
        productDetailsDescriptionSelector: '.content--description',
        footerJavascriptInlineSelector: '#footer--js-inline'
    },

    /**
     * Requests the HTML structure of the product detail page using AJAX and injects the returned
     * content into the page.
     *
     * @param {Object} values
     * @param {Boolean} pushState
     */
    requestData: function (values, pushState) {
        var me = this,
            stateObj = me._createHistoryStateObject();

        $.loadingIndicator.open({
            closeOnClick: false,
            delay: 100
        });

        $.publish('plugin/swAjaxVariant/onBeforeRequestData', [me, values, stateObj.location]);

        values.template = 'ajax';

        if (stateObj.params.hasOwnProperty('c')) {
            values.c = stateObj.params.c;
        }

        $.ajax({
            url: stateObj.location,
            data: values,
            method: 'GET',
            success: function (response) {
                var $response = $($.parseHTML(response, document, true)),
                    $productDetails,
                    $productDescription,
                    ordernumber;

                // Replace the content
                $productDetails = $response.find(me.opts.productDetailsSelector);
                $(me.opts.productDetailsSelector).html($productDetails.html());

                // Replace the accessories
                $productBundlePanel = $response.find(me.opts.productBundlePanel);
                $(me.opts.productBundlePanel).html($productBundlePanel.html());
   // Replace the accessories
                $productBundlePanelNew = $response.find(me.opts.productBundlePanelNew);
                $(me.opts.productBundlePanelNew).html($productBundlePanelNew.html());

                // Replace the description box
                $productDescription = $response.find(me.opts.productDetailsDescriptionSelector);
                $(me.opts.productDetailsDescriptionSelector).html($productDescription.html());

                // Get the ordernumber for the url
                ordernumber = $.trim(me.$el.find(me.opts.orderNumberSelector).text());

                // Update global variables
                window.controller = window.snippets = window.themeConfig = window.lastSeenProductsConfig = window.csrfConfig = null;
                $(me.opts.footerJavascriptInlineSelector).replaceWith($response.filter(me.opts.footerJavascriptInlineSelector));
                StateManager.addPlugin('*[data-image-slider="true"]', 'swImageSlider')
                    .addPlugin('.product--image-zoom', 'swImageZoom', 'xl')
                    .addPlugin('*[data-image-gallery="true"]', 'swImageGallery')
                    .addPlugin('*[data-add-article="true"]', 'swAddArticle')
                    .addPlugin('*[data-modalbox="true"]', 'swModalbox');

                // Replace the async ready to fire the callbacks right after registration
                if (Object.prototype.hasOwnProperty.call(window, 'replaceAsyncReady') && typeof (window.replaceAsyncReady) === 'function') {
                    window.replaceAsyncReady();
                }

                // Plugin developers should subscribe to this event to update their plugins accordingly
                $.publish('plugin/swAjaxVariant/onRequestData', [me, response, values, stateObj.location]);

                if (pushState && me.hasHistorySupport) {
                    var location = stateObj.location + '?number=' + ordernumber;

                    if (stateObj.params.hasOwnProperty('c')) {
                        location += '&c=' + stateObj.params.c;
                    }

                    window.history.pushState(stateObj.state, stateObj.title, location);
                }
            },
            complete: function () {
                $.loadingIndicator.close();
            }
        });
    },
});
