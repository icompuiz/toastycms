Model.Group =  Model.ToastyModel.extend({
	urlRoot: '/groups/view',
	defaults: {
    },
    initialize: function() {
        var group = this.get('Group');
        var id = group.id;
        this.set('id', id);
    },
    fetch: function() {

        var self = this;
        var view = this.view;

        var success = function() {

			var users = self.get('Users');
            var usersCollection = new Model.UserCollection();

            users.forEach(function(item, index) {

                var userModel = new Model.User(
                        {
                            User: item
                        }
                );

                usersCollection.add(userModel);

            });

            self.set('users', usersCollection);

            if (view) {
                view.renderChildren();
            }

        };

		var options = {};
        options.success = success;
        return Backbone.Model.prototype.fetch.call(this, options);
    }
});

Model.GroupCollection = Model.ToastyCollection.extend({

	urlRoot: '/groups/index',
    model: Model.Group

});

Model.UserCollection = Model.ToastyCollection.extend({

	fetch: function() {},
	model: Model.User

});

Model.User = Model.ToastyModel.extend({

	urlRoot: '/users/view',
	defaults: {
    },
    initialize: function() {
        var user = this.get('User');
        var id = user.id;
        this.set('id', id);
    },

});

View.GroupListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('Group');
        var id = "group_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var group = this.model.get('Group');

        var innerHtml = group.name;
        var id = group.id;

        var group_id = 'group_' + id;

        var vars = {
            innerHtml: innerHtml,
            group_id: 'group_' + id,
            id: id
        };

        var templateSource = $("#group-list-item-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.attr("id", group_id);
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

            this.$('.user-list').remove();
        }

    },
    renderChildren: function() {

        var users = this.model.get('users');
        if (users.length > 0) {

            var userList = new View.UserList({
                model: users

            });

            var element = userList.render();

            this.$el.append(element.$el);

        } else {
            this.$('.expanded').trigger("click");
        }


    }
});

View.UserListItem = View.ToastyListItem.extend({
    initialize: function() {
        var model = this.model.get('User');
        var id = "user_" + model.id;
        this.itemState = new ListItemState({identifier: id});
    },
    render: function() {
        var user = this.model.get('User');

        var innerHtml = user.username;
        var id = user.id;

        var user_id = 'user_' + id;

        var vars = {
            innerHtml: innerHtml,
            user_id: 'user_' + id,
            id: id
        };

        var templateSource = $("#user-list-item-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.attr("id", user_id);
        this.$el.html(template);

        return this;
    }
});

View.GroupList = View.ToastyList.extend({
    render: function() {

        var templateSource = $("#group-list-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.append(template);

        var itemHtml = '';
        var self = this;

        $.each(this.model.models,
                function(index, group) {

                    // put the root element in first

                    var item = new View.GroupListItem(
                            {
                                model: group
                            }
                    );

                    group.setView(item);

                    item.render();

                    self.$('.group-list').append(item.$el);

                }
        );

        var vars = {
            listItems: itemHtml
        };


        return this;

    }

});

View.UserList = View.ToastyList.extend({
    render: function() {

        var templateSource = $("#user-list-template").html();
        templateSource = templateSource.trim();

        var template = _.template(templateSource, vars);

        this.$el.append(template);

        var itemHtml = '';
        var self = this;

        $.each(this.model.models,
                function(index, user) {

                    // put the root element in first

                    var item = new View.UserListItem(
                            {
                                model: user
                            }
                    );

                    user.setView(item);

                    item.render();

                    self.$('.user-list').append(item.$el);

                }
        );

        var vars = {
            listItems: itemHtml
        };


        return this;

    }

});