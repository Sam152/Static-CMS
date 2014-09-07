(function ($) {
  $(document).ready(function () {

    var $toolbar = create_toolbar();
    bind_events();

    var $edit_elements = $(window.Static_CMS_selectors);
    var $edit_button = $toolbar.find('.edit-mode');

    var edit_mode = false;

    // Change the state of the page.
    function change_state(state) {
      edit_mode = state;
      $edit_button.text(state ? 'Edit Mode Off' : 'Edit Mode On');
      $edit_elements[state ? 'addClass' : 'removeClass']('static-cms-can-edit');
      $edit_elements.attr('contenteditable', state);
    }

    function bind_events() {
      // Toggle the edit mode.
      $toolbar.find('.edit-mode').click(function () {
        edit_mode = !edit_mode;
        change_state(edit_mode);
      });
      // Trigger the save.
      $toolbar.find('.edit-save').click(function () {
        // Tear the page back to its normal source.
        change_state(false);
        $toolbar.remove();
        $('#static-cms-res').remove();

        $.ajax({
          type: "POST",
          url: '',
          data: {
            content : document.documentElement.innerHTML
          },
          success: function() {
            window.location.href = window.location.href;
          }
        });
      });

    }
  });
  // Create some toolbar HTML.
  function create_toolbar() {
    var $toolbar = $('<div id="static-cms-toolbar"><span class="name">Admin Toolbar</span> <a class="link edit-mode">Edit Mode On</a> <a class="link edit-save">Save</a> <a class="link edit-cancel" href="' + getParameterByName('static_page') + '">Back to website</a></div>');
    $('body').prepend($toolbar);
    return $toolbar;
  }

  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
      results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }
})(jQuery);
