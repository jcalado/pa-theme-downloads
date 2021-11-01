(function(element) {
    const el = element.createElement;

    function customizeTaxonomySelector(OriginalComponent) {
        return function(props) {
            if(props.slug === 'xtt-pa-format' || props.slug === 'xtt-pa-regiao' || props.slug === 'xtt-pa-press-type')
                return el(window.DropdownTermSelector, { ...props });

            return el(OriginalComponent, { ...props });
        };
    }

    wp.hooks.addFilter('editor.PostTaxonomyType', 'adventistas-videos', customizeTaxonomySelector);
}) (
	window.wp.element,
	window.wp.components,
    window.wp.data,
    window.wp.i18n,
    window.lodash,
);