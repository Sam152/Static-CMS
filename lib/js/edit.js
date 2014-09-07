(function($) {
  $(document).ready(function() {
    var $toolbar = create_toolbar();
    var selectors = window.Static_CMS_selectors;
    var edit_mode = false;
    var $edit_elements = $toolbar.find('.edit-mode').click(function() {
      var $this = $(this);
      edit_mode = !edit_mode;
      if (edit_mode) {
        $this.text('Edit Mode Off');
        $(selectors)
          .addClass('static-cms-can-edit')
          .attr('contenteditable', 'true');

      }
      else {
        $this.text('Edit Mode On');
        $(selectors)
          .removeClass('static-cms-can-edit')
          .attr('contenteditable', 'false');;
      }
    });
  });

  function create_toolbar() {
    var $toolbar = $('<div id="static-cms-toolbar"><span class="name">Admin Toolbar</span> <a class="link edit-mode">Edit Mode On</a> <a class="link edit-save">Save</a> <a class="link edit-cancel">Cancel</a></div>');
    $('body').prepend($toolbar);
    return $toolbar;
  }
})(jQuery);
