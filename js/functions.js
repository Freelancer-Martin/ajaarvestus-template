jQuery(document).ready(function($) {
  var attrs = ['for', 'id', 'name'];
  function resetAttributeNames(section) {
      var tags = section.find('input, label'), idx = section.index();
      tags.each(function() {
        var $this = jQuery(this);
        jQuery.each(attrs, function(i, attr) {
          var attr_val = $this.attr(attr);
          if (attr_val) {
              $this.attr(attr, attr_val.replace(/\[bus_custom\]\[\d+\]\[/, '\[bus_custom\]\['+(idx + 1)+'\]\['))
          }
        })
      })
  }

  // Clone the previous section, and remove all of the values
  jQuery('.repeat').click(function(e){
          e.preventDefault();
          var lastRepeatingGroup = jQuery('.repeating').last();
          var cloned = lastRepeatingGroup.clone(true)
          cloned.insertAfter(lastRepeatingGroup);
          cloned.find("input").val("");
          cloned.find("select").val("");
          cloned.find("input:radio").attr("checked", false);
          resetAttributeNames(cloned)
      });



/*
  $(function() {
      var scntDiv = $('#p_scents');
      var i = $('#p_scents p').size() + 1;

      $('#addScnt').live('click', function() {
              $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i +'" value="" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
              i++;
              return false;
      });

      $('#remScnt').live('click', function() {
              if( i > 2 ) {
                      $(this).parents('p').remove();
                      i--;
              }
              return false;
      });
    });

*/
});
