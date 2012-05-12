    <div id="fb-root"></div>
     <script type="text/javascript">

{literal}

            window.fbAsyncInit = function() {
                FB.init({appId: '134093329977136', status: true, cookie: true, xfbml: true});

                /* All the events registered */
                FB.Event.subscribe('auth.login', function(response) {
                    // do something with response
                    login();
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response
                    logout();
                });
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());

            function login(){
                document.location.href = "http://jobberland.com/demo/plugins/facebook/process_data.php";
            }
            function logout(){
                document.location.href = "http://jobberland.com/demo/login";
            }
{/literal}

</script>
<p>
	<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button>
</p>
