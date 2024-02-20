/* eslint-disable consistent-return */
/* eslint-disable no-undef */
/* eslint-disable no-new */
function blockSetup() {
  /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */

  const blockType = 'banner';
  const blockClass = `block--${blockType}`;

  const { propertiesUrl } = blockBanner;

  function initSelect2(block) {
    jQuery(block).find('select').select2({
      minimumResultsForSearch: Infinity,
    });
  }

  function initBlock(block) {
    const selects = block.querySelectorAll('select');
    const button = block.querySelector('button');

    button.addEventListener('click', () => {
      const url = new URL(propertiesUrl);

      if (url) {
        selects.forEach((select) => {
          url.searchParams.set(select.name, select.value);
        });
        // eslint-disable-next-line no-restricted-globals
        location.assign(url.toString());
      }
    });
  }

  /**
     * Initialize each block on page load (front end).
     */
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll(`.${blockClass}`).forEach((block) => {
      initSelect2(block);
      initBlock(block);
    });
  });

  /**
     * Initialize dynamic block preview (editor).
     */
  const initializeBlock = function ($block) {
    const block = $block[0].querySelector(`.${blockClass}`);

    if (block) {
      initSelect2(block);
      initBlock(block);
    }
  };

  if (window.acf) {
    window.acf.addAction(
      `render_block_preview/type=${blockType}`,
      initializeBlock
    );
  }
}
blockSetup();
