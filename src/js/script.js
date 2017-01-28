define(['jquery'], function($){
    var CustomWidget = function () {
    	var widget = this,
            system = widget.system();

		// gulp include example
		//=require utils.js
		
		this.callbacks = {
			render: function(){
				if (typeof (AMOCRM.data.current_card) != 'undefined' && AMOCRM.data.current_card.id == 0) {
                    return false; // // do not render on contacts/add || leads/add if needed
                }

				// simple layout
				var html = '<div class="xtratio_mywidget-wrap">This is widget example</div>' +
				'<link type="text/css" rel="stylesheet" href="' + widget.params.path + '/style.css">';

				widget.render_template({
                    caption: {
                        class_name: "xtratio_mywidget"
                    },
                    body: html,
                    render: ''
                });

				// template load example 1
				utils.getTemplate(
                    'template_example',
                    function(template) {
                        $('.xtratio_mywidget-wrap').append(
                            template.render({
									model: { value: 12.56 }
                                }
                            )
                        )
                    });
				
				// template load example 2
				utils.getTemplate(
                    'template_example_array',
                    function(template) {
                        $('.xtratio_mywidget-wrap').append(
                            template.render({
                                    id: 'xtratio_mywidget_example_array',
                                    items: [
                                        { id: "example_item_1", url: "#", action: "foo", name: "item 2" },
                                        { id: "example_item_2", url: "#", action: "bar", name: "item 2" }
                                    ]
                                }
                            )
                        )
                    });

				return true;
			},
			init: function(){
				console.log('init');
				return true;
			},
			bind_actions: function(){
				console.log('bind_actions');
				return true;
			},
			settings: function(){
				return true;
			},
			onSave: function(){
				alert('click');
				return true;
			},
			destroy: function(){
				
			},
			contacts: {
					//select contacts in list and clicked on widget name
					selected: function(){
						console.log('contacts');
					}
				},
			leads: {
					//select leads in list and clicked on widget name
					selected: function(){
						console.log('leads');
					}
				},
			tasks: {
					//select taks in list and clicked on widget name
					selected: function(){
						console.log('tasks');
					}
				}
		};
		return this;
    };

return CustomWidget;
});