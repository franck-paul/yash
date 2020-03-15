/*global $ */
'use strict';

$(function() {
  $('#yash-cancel').on('click', function() {
    window.close();
    return false;
  });

  $('#yash-ok').on('click', function() {
    sendClose();
    window.close();
    return false;
  });

  function sendClose() {
    const insert_form = $('#yash-form').get(0);
    if (insert_form == undefined) {
      return;
    }
    const tb = window.opener.the_toolbar;
    const data = tb.elements.yash.data;
    data.syntax = insert_form.syntax.value;
    tb.elements.yash.fncall[tb.mode].call(tb);
  }
});
