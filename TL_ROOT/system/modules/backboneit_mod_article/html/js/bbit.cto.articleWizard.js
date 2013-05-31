(function($) {
	window.addEvent("domready", function() {
		var CLS = "bbit_cto_articleWizard";

		$("container").addEvent("click", function(event) {
			var a = $(event.target), id;
			if(!a || !a.hasClass(CLS) && !(a = a.getParent("a." + CLS)) && a.hasClass(CLS)) return;

			event.preventDefault();
			id = a.getPrevious("select");
			if(!id) return;
			id = id.get("value");
			if(!id) return;

			window.open(a.get("href") + id);
		});
	});
})(document.id);