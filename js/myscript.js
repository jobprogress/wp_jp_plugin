jQuery(function($) {
	$(".jobprogress-connect").live('click', function(){
        // $.ajax({
        //     type: 'post',
        //     cache: true,
        //     dataType: 'json',
        //     url : "http://jobprogress.dev/api/v1/login",
        //     data: { 
        //         username: 'testdata164@gmail.com',
        //         password: 'dummy123',
        //         grant_type: 'password',
        //         client_id: '12345',
        //         client_secret : 'XraqRySfIhUTuvdfz7ATuJxXYf8aX5MY'
        //     },
        //     success: function(data) {
        //      console.log(data);
        //  },
         $.ajax({
            type: 'get',
            cache: true,
            dataType: 'html',
             // async: false,
            url : "http://jobprogress.dev/api/v1/connect_job_progress",
            success:function(response) {
                var w = window.open('','','height=500,width=500');
                $(w.document.body).html(response);
                console.log(w);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            }
            // complete: function (xhr, status) {
            //     alert('complete');
            // }
        })
    });
});