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

  const blockType = 'map-select';
  const blockClass = `block--${blockType}`;

  const { ajaxUrl, nonce } = blockMapselect;

  function initBlock(block) {
    function ajaxRequest(requestData) {
      // eslint-disable-next-line no-underscore-dangle
      const _data = { action: 'example', data1, data2 };
      fetch(ajaxUrl, {
        method: 'POST',
        body: (new URLSearchParams(_data)).toString(),
        headers: { 'Content-type': 'application/x-www-form-urlencoded' }
      })
        .then((response) => response.json())
        .then((data) => {
          // do something
        });
    }
  }

  /**
   * Initialize each block on page load (front end).
   */
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll(`.${blockClass}`).forEach((block) => {
      initBlock(block);
    });
  });

  /**
   * Initialize dynamic block preview (editor).
   */
  const initializeBlock = function ($block) {
    const block = $block[0].querySelector(`.${blockClass}`);

    if (block) {
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