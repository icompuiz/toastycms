// content

Model.Content = Model.ToastyModel.extend({
    urlRoot: '/contents/view',
    defaults: {
    },
    initialize: function() {
        var content = this.get('Content');

        var id = content.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var childContent = self.get('ChildContent');
            var childContentCollection = new Model.ContentCollection();

            childContent.forEach(function(item, index) {

                var contentModel = new Model.Content(
                        {
                            Content: item
                        }
                );

                childContentCollection.add(contentModel);

            });

            self.set('children', childContentCollection);

            if (view) {
                view.renderChildren();
            }


        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }
});

Model.ContentCollection = Model.ToastyCollection.extend({
    urlRoot: '/contents/index',
    model: Model.Content
});

View.ContentListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('Content');
        var id = "content_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var content = this.model.get('Content');

        var innerHtml = content.name;
        var id = content.id;
        var type = content.type;

        var content_id = 'content_' + id;

        var vars = {
            innerHtml: innerHtml,
            content_id: 'content_' + id,
            id: id
        };
        var templateSource = $("#content-list-item-template").html();
        
        if (type === 'root') {
            
            templateSource = $("#root-content-list-item-template").html();

        }

        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.attr("id", content_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }


        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_down = this.$(".expanded"),
                icon_right = this.$(".collapsed");

        if ('none' !== icon_right.css('display')) {

            icon_right.hide();
            icon_down.show();
            this.model.fetch();

            this.itemState.set('1');

        } else {
            icon_right.show();
            icon_down.hide();

            this.itemState.set('0')

            this.$('.content-list').remove();
        }

    },
    renderChildren: function() {

        var childContent = this.model.get('children');
        if (childContent.length > 0) {

            var contentList = new View.ContentList({
                model: childContent

            });

            var element = contentList.render();

            this.$el.append(element.$el);

        } else {
            this.$('.expanded').trigger("click");
        }


    }
});

View.ContentList = View.ToastyList.extend({
    render: function() {

        var templateSource = $("#content-list-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.append(template);

        var itemHtml = '';
        var self = this;

        $.each(this.model.models,
                function(index, content) {

                    // put the root element in first

                    var item = new View.ContentListItem(
                            {
                                model: content
                            }
                    );

                    content.setView(item);

                    item.render();

                    self.$('.content-list').append(item.$el);

                }
        );

        var vars = {
            listItems: itemHtml
        };


        return this;

    }

});

// content template

Model.ContentTemplate = Model.ToastyModel.extend({
    urlRoot: '/content_templates/view',
    defaults: {
    },
    initialize: function() {
        var content_template = this.get('ContentTemplate');

        var id = content_template.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var childContent = self.get('ChildContentTemplates');
            var childContentTemplateCollection = new Model.ContentTemplateCollection();

            childContent.forEach(function(item, index) {

                var contentModel = new Model.ContentTemplate(
                        {
                            ContentTemplate: item
                        }
                );

                childContentTemplateCollection.add(contentModel);

            });

            self.set('children', childContentTemplateCollection);

            if (view) {
                view.renderChildren();
            }


        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }
});

Model.ContentTemplateCollection = Model.ToastyCollection.extend({
    urlRoot: '/content_templates/index',
    model: Model.ContentTemplate
});

View.ContentTemplateListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('ContentTemplate');
        var id = "content_template_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var content_template = this.model.get('ContentTemplate');

        var innerHtml = content_template.name;
        var id = content_template.id;
        content_id = 'content_template_' + id;


        var vars = {
            innerHtml: innerHtml,
            content_id: 'content_template_' + id,
            id: id
        };

        var templateSource = $("#content-template-list-item-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);
        this.$el.attr("id", content_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }


        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_down = this.$(".expanded"),
                icon_right = this.$(".collapsed");

        if ('none' !== icon_right.css('display')) {
            icon_right.hide();
            icon_down.show();
            this.model.fetch();

            this.itemState.set("1");

        } else {
            icon_right.show();
            icon_down.hide();

            this.itemState.set("0");


            this.$('.content-template-list').remove();
        }

    },
    renderChildren: function() {

        var childContentTemplate = this.model.get('children');
        if (childContentTemplate.length > 0) {

            var contentTemplateList = new View.ContentTemplateList({
                model: childContentTemplate

            });

            var element = contentTemplateList.render();

            this.$el.append(element.$el);

        } else {
            this.$('.expanded').trigger("click");
        }


    }
});

View.ContentTemplateList = View.ToastyList.extend({
    render: function() {
        var templateSource = $("#content-template-list-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        var itemHtml = '';
        var self = this;
        $.each(this.model.models,
                function(index, content_template) {

                    var item = new View.ContentTemplateListItem(
                            {
                                model: content_template
                            }
                    );

                    content_template.setView(item);
                    item.render();


                    self.$('.content-template-list').append(item.$el);

                }
        );

        var vars = {
            listItems: itemHtml
        };


        return this;

    }

});

// content types

Model.ContentType = Model.ToastyModel.extend({
    urlRoot: '/content_types/view',
    defaults: {
    },
    initialize: function() {
        var content_type = this.get('ContentType');

        var id = content_type.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var children = self.get('ChildContentTypes');
            var modelCollection = new Model.ContentTypeCollection();

            children.forEach(function(item, index) {

                var model = new Model.ContentType(
                        {
                            ContentType: item
                        }
                );

                modelCollection.add(model);

            });

            self.set('children', modelCollection);

            if (view) {
                view.renderChildren();
            }


        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }
});

Model.ContentTypeCollection = Model.ToastyCollection.extend({
    urlRoot: '/content_types/index',
    model: Model.ContentType
});

View.ContentTypeListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('ContentType');
        var id = "content_type_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var content_type = this.model.get('ContentType');

        var innerHtml = content_type.name;
        var id = content_type.id;


        var content_id = 'content_type_' + id;
        var vars = {
            innerHtml: innerHtml,
            content_id: 'content_type_' + id,
            id: id
        };

        var templateSource = $("#content-type-list-item-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);
        this.$el.attr("id", content_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }

        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_down = this.$(".expanded"),
                icon_right = this.$(".collapsed");

        if ('none' !== icon_right.css('display')) {
            icon_right.hide();
            icon_down.show();
            this.model.fetch();
            this.itemState.set("1");

        } else {
            icon_right.show();
            icon_down.hide();

            this.itemState.set("0");

            this.$('.content-type-list').remove();
        }

    },
    renderChildren: function() {

        var children = this.model.get('children');
        if (children.length > 0) {

            var list = new View.ContentTypeList({
                model: children

            });

            var element = list.render();

            this.$el.append(element.$el);

        } else {
           this.$('.expanded').trigger("click");
        }


    }
});

View.ContentTypeList = View.ToastyList.extend({

    render: function() {
        var templateSource = $("#content-type-list-template").html();
        templateSource = templateSource.trim();

        var vars = {};
        var template = _.template(templateSource, vars);

        this.$el.html(template);

        var itemHtml = '';
        var self = this;
        $.each(this.model.models,
                function(index, content_type) {

                    var item = new View.ContentTypeListItem(
                            {
                                model: content_type
                            }
                    );

                    content_type.setView(item);

                    item.render();

                    self.$('.content-type-list').append(item.$el);

                }
        );

        var vars = {
            listItems: itemHtml
        };



        return this;

    }

});

// media directories

Model.Media = Model.ToastyModel.extend({

    urlRoot: '/media_directories/view',
    defaults: {
    },
    initialize: function() {
        var model = this.get('Media') ||  this.get('MediaDirectory') ;

        var id = model.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var isMd = undefined !== self.get('MediaDirectory');

            if (isMd) {

                var child_media = self.get('ChildMedia');
                var child_directories = self.get('ChildMediaDirectory');

                var modelCollection = new Model.MediaCollection();

                child_media.forEach(function(item, index) {

                    var model = new Model.Media(
                            {
                                Media: item
                            }
                    );

                    modelCollection.add(model);

                });

                child_directories.forEach(function(item, index) {

                    var model = new Model.Media(
                            {
                                MediaDirectory: item
                            }
                    );

                    modelCollection.add(model);

                });

                self.set('children', modelCollection);

                if (view) {
                    view.renderChildren();
                }

            }


        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }

});
Model.MediaCollection = Model.ToastyCollection.extend({
    urlRoot: '/media_directories/index',
    model: Model.Media
});



View.MediaListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('Media') || this.model.get('MediaDirectory');


        var id = "media_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var media =  this.model.get('Media') || this.model.get('MediaDirectory');

        var isMd = undefined !== this.model.get('MediaDirectory');

        var type = media.type;

        var isRoot = false;
        if ('root_directory' === type) {
            isRoot = true;
        }



        var innerHtml = media.name;
        var id = media.id;


        var media_id = 'media_' + id;
        var vars = {
            innerHtml: innerHtml,
            media_id: media_id,
            id: id
        };


        var templateSource = "";
        if (isRoot) {

            templateSource = $("#root-media-directory-list-item-template").html();
        }
        else if (isMd) {
            templateSource = $("#media-directory-list-item-template").html();
        } else {

            templateSource = $("#media-list-item-template").html();
        }
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);
        this.$el.attr("id", media_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }

        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_open = this.$(".expanded"),
                icon_close = this.$(".collapsed");

        if ('none' !== icon_close.css('display')) {

            icon_close.hide();
            icon_open.show();
            this.model.fetch();
            this.itemState.set("1");

        } else {
            icon_close.show();
            icon_open.hide();

            this.itemState.set("0");

            this.$('.media-list').remove();
        }

    },
    renderChildren: function() {

        var children = this.model.get('children');
        if (children.length > 0) {

            var list = new View.MediaList({
                model: children

            });

            var element = list.render();

            this.$el.append(element.$el);

        }else {
           this.$('.expanded').trigger("click");
        }


    }
});
View.MediaList = View.ToastyList.extend({

     render: function() {

        var templateSource = $("#media-list-template").html();
        templateSource = templateSource.trim();
        var vars = {};

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        var itemHtml = '';
        var self = this;
        $.each(this.model.models,
                function(index, media) {

                    var item = new View.MediaListItem(
                            {
                                model: media
                            }
                    );

                    media.setView(item);


                    item.render();

                    self.$('.media-list').append(item.$el);

                }
        );

        return this;

    }


});

// ----------------------

// Stylesheet 

Model.Stylesheet = Model.ToastyModel.extend({

    urlRoot: '/stylesheets/view',


    defaults: {
    },
    initialize: function() {
        var model = this.get('Stylesheet');

        var id = model.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var stylesheets = self.get('Stylesheets');

            var modelCollection = new Model.StylesheetCollection();

            stylesheets.forEach(function(item, index) {

                var model = new Model.Stylesheet(
                        {
                            Stylesheet: item
                        }
                );

                modelCollection.add(model);

            });


            self.set('children', modelCollection);

            if (view) {
                view.renderChildren();
            }



        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }

});

// Stylesheet Collection
Model.StylesheetCollection = Model.ToastyCollection.extend({
    urlRoot: '/stylesheets/index',
    model: Model.Stylesheet
});



// Stylesheet List Item

View.StylesheetListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('Stylesheet');


        var id = "stylesheet_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var media =  this.model.get('Stylesheet');

        var type = media.type;

        var isRoot = false;
        if ('root' === type) {
            isRoot = true;
        }

        var innerHtml = media.name;
        var id = media.id;


        var media_id = 'stylesheet_' + id;
        var vars = {
            innerHtml: innerHtml,
            stylesheet_id: media_id,
            id: id
        };


        var templateSource = "";
        if (isRoot) {

            templateSource = $("#root-stylesheet-list-item-template").html();
        } else {

            templateSource = $("#stylesheet-list-item-template").html();
        }

        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);
        this.$el.attr("id", media_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }

        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_open = this.$(".expanded"),
                icon_close = this.$(".collapsed");

        if ('none' !== icon_close.css('display')) {

            icon_close.hide();
            icon_open.show();
            this.model.fetch();
            this.itemState.set("1");

        } else {
            icon_close.show();
            icon_open.hide();

            this.itemState.set("0");

            this.$('.stylesheet-list').remove();
        }

    },
    renderChildren: function() {

        var children = this.model.get('children');
        if (children.length > 0) {

            var list = new View.StylesheetList({
                model: children

            });

            var element = list.render();

            this.$el.append(element.$el);

        }else {
           this.$('.expanded').trigger("click");
        }


    }
});

// Stylesheet List

View.StylesheetList = View.ToastyList.extend({

     render: function() {

        var templateSource = $("#stylesheet-list-template").html();
        templateSource = templateSource.trim();
        var vars = {};

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        var itemHtml = '';
        var self = this;
        $.each(this.model.models,
                function(index, stylesheet) {

                    var item = new View.StylesheetListItem(
                            {
                                model: stylesheet
                            }
                    );

                    stylesheet.setView(item);


                    item.render();

                    self.$('.stylesheet-list').append(item.$el);

                }
        );

        return this;

    }


});


// ----------------------

// Javascript 

Model.Javascript = Model.ToastyModel.extend({

    urlRoot: '/javascripts/view',


    defaults: {
    },
    initialize: function() {
        var model = this.get('Javascript');

        var id = model.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var javascripts = self.get('Javascripts');

            var modelCollection = new Model.JavascriptCollection();

            javascripts.forEach(function(item, index) {

                var model = new Model.Javascript(
                        {
                            Javascript: item
                        }
                );

                modelCollection.add(model);

            });


            self.set('children', modelCollection);

            if (view) {
                view.renderChildren();
            }



        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }

});

// Javascript Collection
Model.JavascriptCollection = Model.ToastyCollection.extend({
    urlRoot: '/javascripts/index',
    model: Model.Javascript
});



// Javascript List Item

View.JavascriptListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('Javascript');


        var id = "javascript_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var media =  this.model.get('Javascript');

        var type = media.type;

        var isRoot = false;
        if ('root' === type) {
            isRoot = true;
        }

        var innerHtml = media.name;
        var id = media.id;


        var media_id = 'javascript_' + id;
        var vars = {
            innerHtml: innerHtml,
            javascript_id: media_id,
            id: id
        };


        var templateSource = "";
        if (isRoot) {

            templateSource = $("#root-javascript-list-item-template").html();
        } else {

            templateSource = $("#javascript-list-item-template").html();
        }

        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);
        this.$el.attr("id", media_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }

        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_open = this.$(".expanded"),
                icon_close = this.$(".collapsed");

        if ('none' !== icon_close.css('display')) {

            icon_close.hide();
            icon_open.show();
            this.model.fetch();
            this.itemState.set("1");

        } else {
            icon_close.show();
            icon_open.hide();

            this.itemState.set("0");

            this.$('.javascript-list').remove();
        }

    },
    renderChildren: function() {

        var children = this.model.get('children');
        if (children.length > 0) {

            var list = new View.JavascriptList({
                model: children

            });

            var element = list.render();

            this.$el.append(element.$el);

        }else {
           this.$('.expanded').trigger("click");
        }


    }
});

// Javascript List

View.JavascriptList = View.ToastyList.extend({

     render: function() {

        var templateSource = $("#javascript-list-template").html();
        templateSource = templateSource.trim();
        var vars = {};

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        var itemHtml = '';
        var self = this;
        $.each(this.model.models,
                function(index, javascript) {

                    var item = new View.JavascriptListItem(
                            {
                                model: javascript
                            }
                    );

                    javascript.setView(item);


                    item.render();

                    self.$('.javascript-list').append(item.$el);

                }
        );

        return this;

    }


});

// Snippet

// Snippet COllection

// Snippet List Item

// Snippet List

Model.Snippet = Model.ToastyModel.extend({

    urlRoot: '/snippets/view',


    defaults: {
    },
    initialize: function() {
        var model = this.get('Snippet');

        var id = model.id;

        this.set('id', id);

    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

            var snippets = self.get('Snippets');

            var modelCollection = new Model.SnippetCollection();

            snippets.forEach(function(item, index) {

                var model = new Model.Snippet(
                        {
                            Snippet: item
                        }
                );

                modelCollection.add(model);

            });


            self.set('children', modelCollection);

            if (view) {
                view.renderChildren();
            }



        };
        var options = {};
        options.success = success;

        return Backbone.Model.prototype.fetch.call(this, options);
    }

});

// Snippet Collection
Model.SnippetCollection = Model.ToastyCollection.extend({
    urlRoot: '/snippets/index',
    model: Model.Snippet
});



// Snippet List Item

View.SnippetListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('Snippet');


        var id = "snippet_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var media =  this.model.get('Snippet');

        var type = media.type;

        var isRoot = false;
        if ('root' === type) {
            isRoot = true;
        }

        var innerHtml = media.name;
        var id = media.id;


        var media_id = 'snippet_' + id;
        var vars = {
            innerHtml: innerHtml,
            snippet_id: media_id,
            id: id
        };


        var templateSource = "";
        if (isRoot) {

            templateSource = $("#root-snippet-list-item-template").html();
        } else {

            templateSource = $("#snippet-list-item-template").html();
        }

        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);
        this.$el.attr("id", media_id);
        this.$el.html(template);

        var current_state = this.itemState.get();

        if ("1" === current_state) {
            this.$('.collapsed').trigger("click");
        }

        return this;
    },
    expand: function(e) {

        e.stopImmediatePropagation();

        var icon_open = this.$(".expanded"),
                icon_close = this.$(".collapsed");

        if ('none' !== icon_close.css('display')) {

            icon_close.hide();
            icon_open.show();
            this.model.fetch();
            this.itemState.set("1");

        } else {
            icon_close.show();
            icon_open.hide();

            this.itemState.set("0");

            this.$('.snippet-list').remove();
        }

    },
    renderChildren: function() {

        var children = this.model.get('children');
        if (children.length > 0) {

            var list = new View.SnippetList({
                model: children

            });

            var element = list.render();

            this.$el.append(element.$el);

        }else {
           this.$('.expanded').trigger("click");
        }


    }
});

// Snippet List

View.SnippetList = View.ToastyList.extend({

     render: function() {

        var templateSource = $("#snippet-list-template").html();
        templateSource = templateSource.trim();
        var vars = {};

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        var itemHtml = '';
        var self = this;
        $.each(this.model.models,
                function(index, snippet) {

                    var item = new View.SnippetListItem(
                            {
                                model: snippet
                            }
                    );

                    snippet.setView(item);


                    item.render();

                    self.$('.snippet-list').append(item.$el);

                }
        );

        return this;

    }


});