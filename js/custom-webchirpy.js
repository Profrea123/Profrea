$(function () {  

  $('#locality-list').select2({
  minimumInputLength: 3,
  allowClear: true,
  placeholder: '',
    ajax: {
      url: './ajax/get-locality-ep.php',
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
         return {
          results: data
        };
      },
      data: function (params) {

        var city = $('#city-list').val();
        if(!city)
          {
            alert('Please select city first');
            return false;
          }
        var city_id = city.split(",")[1];
        var query = {
          search: params.term,
          city: city_id
        }
  
        // Query parameters will be ?search=[term]&type=public
        return query;
      }
    }
  });

  /*$("#locality-list").keyup(function() {
    var name = $('#locality-list').val();
    var city = $('#city-list').val();
    var city_id = city.split(",")[1];
    console.log(city_id);
    if (name == "") {
      $("#result").hide();
    } else {
      $.ajax({
            type: "POST",
            url:  "./ajax/get-locality-ep.php",
            data: {
            search: name,
            city_id: city_id
            }, success: function(html) {
                $('#result').html(html).show();
                $("#result option").click(function() {
                  fill($(this).attr('href'),$(this).text());
                });
            }});
    }
});*/

    // Webchirpy Custom Js
    $("#spaceProviderSubmit").on("click",function(e){
        e.preventDefault();
        if ( $("#spaceProviderForm").parsley().isValid() )
        {
          $("#spaceProviderForm").submit();
          return true;
        }else {
          return false;
        }

      });
});    