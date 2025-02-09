/*global dotclear */
'use strict';

dotclear.ready(() => {
  document.getElementById('yash-cancel')?.addEventListener('click', (event) => {
    event.preventDefault();
    windows.close();
    return false;
  });

  document.getElementById('yash-ok')?.addEventListener('click', (event) => {
    event.preventDefault();
    const insert_form = document.getElementById('yash-form');
    if (insert_form === undefined) {
      return;
    }
    const tb = window.opener.the_toolbar;
    const { data } = tb.elements.yash;
    data.syntax = insert_form.syntax.value;
    tb.elements.yash.fncall[tb.mode].call(tb);
    window.close();
    return false;
  });
});
