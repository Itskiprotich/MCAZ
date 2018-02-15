$(function() {
    // $(document).on('click', '#registerUser', reloadLabTests);

    //TODO: refresh page on successful cancel modal button.

    $(".vigibase").click(function(event) {
      event.preventDefault();
      if(confirm("Are you sure you want to send to VigiBase?")) {          
          // var frm = $('#frmAssignEvaluator');
          url = $(this).attr("href");
          em = $(this);
          $.blockUI({ css: { 
              border: 'none', 
              padding: '15px', 
              backgroundColor: '#000', 
              '-webkit-border-radius': '10px', 
              '-moz-border-radius': '10px', 
              opacity: .5, 
              color: '#fff' 
          } }); 

          $.ajax({
              async:true,
              type: 'GET',
              url: url,
              success: function (data) {
                  // $('#registrationModal').modal('hide')
                  console.log(data, $(this).closest("td"));
                  em.closest("td").empty().html(data.umc.MessageId);
                  $.unblockUI();
              },
              error: function (data) {
                  //TODO: Remember to remove console.logs during deploy
                  console.log('An error occurred.');
                  console.log(data);
                  $.unblockUI();
              },
          });
      }
    });
    
});
