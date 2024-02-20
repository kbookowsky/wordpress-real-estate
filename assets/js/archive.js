function initArchive() {
  // eslint-disable-next-line no-undef
  const { ajaxUrl, nonce } = archiveData;
  const items = document.querySelector('.archive__items');
  const buttonWrapper = document.querySelector('.archive__load-more');
  const button = buttonWrapper.querySelector('button');

  function ajaxRequest(filtersChange) {
    let paged;

    if (filtersChange) {
      paged = 0;
    } else {
      paged = items.dataset.page;
    }

    const transactionType = document.querySelector('select[name="transaction_type"]').value;
    const propertyType = document.querySelector('select[name="property_type"]').value;
    const propertyCity = document.querySelector('select[name="property_city"]').value;
    const priceMin = document.querySelector('input[name="property_price_min"]').value;
    const priceMax = document.querySelector('input[name="property_price_max"]').value;

    // eslint-disable-next-line no-underscore-dangle
    const _data = {
      action: 'archive', paged, transactionType, propertyType, propertyCity, priceMin, priceMax, nonce,
    };

    if (!filtersChange) {
      button.classList.add('loading');
    }

    items.classList.add('loading');

    fetch(ajaxUrl, {
      method: 'POST',
      body: (new URLSearchParams(_data)).toString(),
      headers: { 'Content-type': 'application/x-www-form-urlencoded' },
    })
      .then((response) => response.json())
      .then((data) => {
        if (filtersChange) {
          items.querySelectorAll('.card-property').forEach((item) => {
            item.remove();
          });
        }

        buttonWrapper.insertAdjacentHTML('beforebegin', data.posts);

        // eslint-disable-next-line no-undef
        project.onScroll();

        if (data.page === data.maxPage) {
          buttonWrapper.classList.add('hidden');
        } else if (data.maxPage > 1) {
          buttonWrapper.classList.remove('hidden');
          items.dataset.page = data.page;
        }

        items.classList.remove('loading');
        button.classList.remove('loading');
      });
  }

  button.addEventListener('click', () => { ajaxRequest(false); });

  document.querySelectorAll('input').forEach((item) => {
    item.addEventListener('change', () => { ajaxRequest(true); });
  });

  jQuery('select').on('select2:select', () => { ajaxRequest(true); });
}
initArchive();

jQuery('select').select2({
  minimumResultsForSearch: Infinity,
});
