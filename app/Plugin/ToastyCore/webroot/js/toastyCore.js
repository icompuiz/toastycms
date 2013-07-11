var Model = ToastyCore.Model;
var Global = ToastyCore.Global;
var View = ToastyCore.View;

Model.ToastyModel = Backbone.Model.extend({
    url: function() {
        return Global.coreUrl + this.urlRoot + '/' + this.id + '.json';
    },
    view: null,
    setView: function(view) {
        this.view = view;
    },
    fetch: function() {

        return Backbone.Model.prototype.fetch.call(this, {});


    }
});

Model.ToastyCollection = Backbone.Collection.extend({
    url: function() {
        return Global.coreUrl + this.urlRoot + '.json';
    },
    view: null,
    setView: function(view) {
        this.view = view;
    },
    fetch: function() {

        var view = this.view;
        var success = function() {

            if (view) {
                view.render();
            }
        };
        var options = {};
        options.success = success;

        return Backbone.Collection.prototype.fetch.call(this, options);


    }
});

View.ToastyList = Backbone.View.extend({
    tagName: "div",
    className: "sidebar-list",
    initialize: function() {
        this.model.setView(this);
    }

});



View.ToastyListItem = Backbone.View.extend({
    tagName: "li",
    className: "sidebar-list-item nav-header",
    events: {
        "click .collapsed, .expanded": 'expand'
    },
    initialize: function() {



    },
    expand: function() {
        console.log(this);
    },
    preventDefault: function(e) {


    }
});