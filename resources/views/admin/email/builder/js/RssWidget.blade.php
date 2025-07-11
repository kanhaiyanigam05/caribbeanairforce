<script>
    // Rss Widget
    class RssWidget extends Widget {
        getHtmlId() {
            return "RssWidget";
        }

        init() {
            var _this = this;

            // default button html
            this.setButtonHtml(`
                <div class="_1content widget-text">
                    <div class="panel__body woo-panel__body" title="RSS">
                        <div class="image-drag">
                            <div ng-bind-html="::getModuleIcon(module)" class="ng-binding product-list-widget">
                                <img builder-element style="width:50px;opacity:0.5" src="{{ url('admins/images/rss_widget.svg') }}" width="100%" />
                            </div>
                        </div>
                        <div class="body__title">RSS</div>
                    </div>
                </div>
            `);

            // default content html
            var config = Base64.encode(JSON.stringify({!! json_encode(\App\Models\Template::defaultRssConfig()) !!}));
            this.setContentHtml(`
                <div id="` + this.id + `"
                    class="rss-widget"
                    builder-element="RssElement"
                    builder-draggable
                    data-preview="no"
                    data-config='` + config + `'
                ></div>
            `);

            // default dragging html
            this.setDraggingHtml(this.getButtonHtml());

            // before save events: remove placeholder before save
            currentEditor.addBeforeSaveEvent(function() {
                // find placeholder
                if (!_this.getPlaceholder().length) {
                    return;
                }

                // find closest block element
                var blockElement = _this.getPlaceholder().closest('[builder-element="BlockElement"]');
                blockElement.remove();
            });
        }

        getPlaceholder() {
            return this.getElement().find('[f-role="placeholder"]');
        }

        getElement() {
            return currentEditor.getIframeContent().find('#' + this.id);
        }

        drop() {
            var element = currentEditor.elementFactory(this.getElement());

            currentEditor.select(element);
            currentEditor.handleSelect();

            element.render();
        }
    }
</script>
