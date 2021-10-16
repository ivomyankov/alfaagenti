// Each alert shows and hides one after another delayed by 1 sec
$.each( $(".alert"), function(index) {
  var delay = (index+2)*1000
$(this).fadeIn(1000).delay( delay ).fadeOut(1000);
});

function rearange(position){
  //alert(position);
  console.log('success1:');
  $.ajax({
    type: "post",
    url: "/dashboard/imagereposition",   
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
    dataType: 'json',
    data: position,    
    contentType: 'application/json; charset=utf-8',
    success: function (data) {
      console.log('success2:'+data);
      //window.location.replace("https://nc-db.mediaservices.biz/public/company/"+company);
      //alert(data.status);
    },
    error: function (xhr, status, error) {
        alert("XCR: "+xhr+", "+" / Status: "+status+"", " / Error:, "+error);
    }
  });
  
}

window.onload = function() {
  
}