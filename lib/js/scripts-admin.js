jQuery(function($) {



    /**
     * TABS
     */
    var hash = window.location.hash;
    if (hash != '') {
        $('.nav-tab-wrapper').children().removeClass('nav-tab-active');
        $('.nav-tab-wrapper a[href="' + hash + '"]').addClass('nav-tab-active');

        $('.tabs-content').children().addClass('hidden');
        $('.tabs-content div' + hash.replace('#', '#tab-')).removeClass('hidden');
    }

    $('.nav-tab-wrapper a').click(function() {
        var tab_id = $(this).attr('href').replace('#', '#tab-');

        // active tab
        $(this).parent().children().removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        // active tab content
        $('.tabs-content').children().addClass('hidden');
        $('.tabs-content div' + tab_id).removeClass('hidden');
    });


    var bgType = $('#bg_type');
    /*alert(bgType.val());*/
    if(bgType.val() == 'color'){
        $('#customcolor').show();
        $('#bgimg').hide();
    }
    else if(bgType.val()=='image'){
        $('#customcolor').hide();
        $('#bgimg').show();
    }
    // On Select option changed
    bgType.change(function(){
        // Check if current value is "audi"
        if($(this).val() == 'color'){
            // Show input field
            $('#customcolor').show();
            $('#bgimg').hide();   //This changes display to block
        }else if($(this).val()=='image'){
            // Hide input field
            $('#customcolor').hide();
              $('#bgimg').show();
        }
    });


 $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#image_url').val(image_url);
        });
    });


    /**
     * COLOR PICKER
     */
     $('.color-picker').wpColorPicker();
    //   $('.color_picker_trigger').wpColorPicker();   }
   
});

