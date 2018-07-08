{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>tchat card - Bootsnipp.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>
    {{--<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{--<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{--<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
{{--</head>--}}
{{--<body>--}}

<!DOCTYPE html><html class=''>
<head>
    {{--<script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />--}}
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

    <script src="https://use.typekit.net/hoy3lrg.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    {{--<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
</head>
<body>
<!--

A concept for a chat interface.

Try writing a new message! :)


Follow me here:
Twitter: https://twitter.com/thatguyemil
Codepen: https://codepen.io/emilcarlsson/
Website: http://emilcarlsson.se/

-->

<div id="frame">
    <div id="sidepanel">
        <div id="profile">
            <div class="wrap" id="current_user" user_id="{{ Auth::user()->id }}">
                <img id="profile-img" src="{{ Auth::user()->image }}" class="online" alt="">
                <p>{{ Auth::user()->name }}</p>
                <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                <div id="status-options">
                    <ul>
                        <li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
                        <li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
                        <li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
                        <li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
                    </ul>
                </div>
                <div id="expanded">
                    <label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
                    <input name="twitter" type="text" value="mikeross" />
                    <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
                    <input name="twitter" type="text" value="ross81" />
                    <label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
                    <input name="twitter" type="text" value="mike.ross" />
                </div>
            </div>
        </div>
        <div id="search">
            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            <input type="text" placeholder="Search contacts..." />
        </div>
        <div id="contacts">
            <ul>
                @foreach($all_contacts as $contact)
                    <li class="contact" {{ (isset($contact->group_id)) ? "group_id=$contact->group_id" : "user_id=$contact->id" }}>
                        <div class="wrap">
                            <span class="contact-status online"></span>
                            <img src="{{ $contact->image }}" alt="Ảnh đại diện của {{ $contact->name }}" />
                            <div class="meta">
                                <p class="name">{{ $contact->name }}</p>
                                <p class="preview">{{ ($contact->last_message) ?? 'Ready to chat' }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="bottom-bar">
            <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
            <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
        </div>
    </div>
    <div class="content">
        <div class="contact-profile">
            {{--<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />--}}
            {{--<p>Harvey Specter</p>--}}
            <div class="social-media">
                <a type="button" id="logout" href="{{ route('logout') }}">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <span class="make_group" data-toggle="tooltip" data-placement="bottom" title="Tạo nhóm"><span data-toggle="modal" data-target="#myModal"><i class="fas fa-users" aria-hidden="true" style="margin-right: 0"></i></span></span>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Tạo nhóm</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <label for="enter_group_name">Group Name:</label>
                                        <input type="text" class="form-control" id="enter_group_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="enter_group_image">Group Image:</label>
                                        <input type="text" class="form-control" id="enter_group_image" required>
                                    </div>
                                    <div class="checkbox">
                                        @foreach ($users as $user)
                                            <label><input type="checkbox" value="{{ $user->id }}">{{ $user->name }}</label>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-default" id="create_group">Submit</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <i class="fab fa-facebook" aria-hidden="true"></i>
                <i class="fab fa-twitter" aria-hidden="true"></i>
                <i class="fab fa-instagram" aria-hidden="true"></i>
            </div>
        </div>

        <div class="messages">
            <img src="{{ asset("image/ajax-loader.gif") }}" id="ajax-loader">
            <ul>
            </ul>
        </div>

        <div class="message-input">
            <div class="wrap">
                <input type="text" placeholder="Write your message..." autofocus="autofocus"/>
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
{{--<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
<script >$(".messages").animate({ scrollTop: $(document).height() }, "fast");

    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
        $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };

        $("#status-options").removeClass("active");
    });
    //# sourceURL=pen.js
</script>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset('js/chat.js') }}"></script>
<script src="{{ asset('js/loadMsgOnClickContact.js') }}"></script>
<script src="{{ asset('js/CreateGroup.js') }}"></script>
<script src="{{ asset('js/loadMsgOnScroll.js') }}"></script>