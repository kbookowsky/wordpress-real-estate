/* eslint-disable no-undef */
wp.domReady(() => {
  wp.blocks.unregisterBlockStyle(
    'core/button',
    ['squared', 'fill', 'outline']
  );
  wp.blocks.registerBlockStyle('core/button', {
    name: 'primary',
    label: 'Primary',
  });
  wp.blocks.registerBlockStyle('core/button', {
    name: 'inline',
    label: 'Inline',
  });
});
