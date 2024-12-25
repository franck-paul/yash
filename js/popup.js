/*global $ */
'use strict';

dotclear.ready(() => {
  $('#yash-cancel').on('click', () => {
    window.close();
    return false;
  });

  $('#yash-ok').on('click', () => {
    const insert_form = $('#yash-form').get(0);
    if (insert_form == undefined) {
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
