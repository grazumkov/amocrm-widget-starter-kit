var utils = {
	// custom twig template load example
	getTemplate: function (template, callback) {
		template = template || '';

		return widget.render({
			href:'/templates/' + template + '.twig',
			base_path:widget.params.path,
			load: callback
		},{});
	}
};