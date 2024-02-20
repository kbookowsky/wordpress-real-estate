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

  const blockType = 'form';
  const blockClass = `block--${blockType}`;

  function initSelect2(block) {
    jQuery(block).find('select').select2({
      minimumResultsForSearch: Infinity,
    });
  }

  /**
       * Initialize each block on page load (front end).
       */
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll(`.${blockClass}`).forEach((block) => {
      initSelect2(block);
    });
  });

  /**
       * Initialize dynamic block preview (editor).
       */
  const initializeBlock = function ($block) {
    const block = $block[0].querySelector(`.${blockClass}`);

    if (block) {
      initSelect2(block);
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
