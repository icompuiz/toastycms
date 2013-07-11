Model.ContentTypePropertySkel = Model.ToastyModel.extend({
    urlRoot: "/content_type_property_skels/view",
    defaults: {
    },
    initialize: function() {
        var ctps = this.get('ContentTypePropertySkel');

        var id = ctps.id;

        this.set('id', id);

    }
});

Model.ContentTypePropertySkelCollection = Model.ToastyCollection.extend({
    urlRoot: "/content_type_property_skels/index",
    model: Model.ContentTypePropertySkel
});

View.ContentTypePropertySkelListItem = View.ToastyListItem.extend({
    render: function() {
        var ctps = this.model.get('ContentTypePropertySkel');

        var innerHtml = ctps.name;
        var id = ctps.id;


        var vars = {
            innerHtml: innerHtml,
            content_id: 'ctps_' + id,
            id: id
        };

        var templateSource = $("#ctps-list-item-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        return this;
    }
});

View.ContentTypePropertySkelList = View.ToastyList.extend({
    render: function() {

        var itemHtml = '';
        $.each(this.model.models,
                function(index, ctps) {

                    var item = new View.ContentTypePropertySkelListItem(
                            {
                                model: ctps
                            }
                    );

                    var rendered = item.render();

                    itemHtml += item.$el.html();

                }
        );

        var vars = {
            listItems: itemHtml
        };

        var templateSource = $("#ctps-list-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.html(template);

        return this;

    }

});