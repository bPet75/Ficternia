function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function (e) {
        $('#cover').attr('src', e.target.result).width(290).height(415);
      };
  
      reader.readAsDataURL(input.files[0]);
    }
  }
  function readLocURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function (e) {
        $('#cover').attr('src', e.target.result).width(400).height(200);
      };
  
      reader.readAsDataURL(input.files[0]);
    }
  }